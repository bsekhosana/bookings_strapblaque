<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\PayFastService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Subscriptions",
 *     description="Operations related to subscriptions"
 * )
 */
class SubscriptionController extends Controller
{
    protected $payFastService;

    public function __construct(PayFastService $payFastService)
    {
        $this->payFastService = $payFastService;
    }

    public function showOrganizationActivation()
    {
        $organization = auth()->user()->organizations->first();

        if(!empty($organization && $organization->status == 'Active')){

            return redirect()->route('admin.organization.services');

        }

        $plans = SubscriptionPlan::where('status', 'Active')->get();

        return view('admin.organizations.activation', compact('plans'));
    }

    public function showOrganizationSettings()
    {
        $organization = auth()->user()->organizations->first();

        if(!empty($organization && $organization->status == 'Active')){

            if(count($organization->settings) > 0){

                return redirect()->route('admin.dashboard');

            }

            return  view('admin.organizations.settings', compact('organization'));

        }

        $plans = SubscriptionPlan::where('status', 'Active')->get();

        return view('admin.organizations.activation', compact('plans'));
    }


    public function showOrganizationStaff()
    {
        $organization = auth()->user()->organizations->first();

        if(!empty($organization && $organization->status == 'Active')){

            return view('admin.organizations.staff_setup', compact('organization'));

        }

        $plans = SubscriptionPlan::where('status', 'Active')->get();

        return view('admin.organizations.activation', compact('plans'));
    }

    public function showOrganizationServices()
    {
        // $organization = auth('admin')->user->organizations->first();

        $organization = auth()->user()->organizations->first(); // Assuming the admin is authenticated

        return view('admin.organizations.services_setup', compact('organization'));
    }

    public function activateOrganization(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->input('plan_id'));
        $organization = Auth::user()->organizations->first();

        $nextBillingDate = $this->calculateNextBillingDate();

        // Handle payment and subscription activation
        $paymentData = [
            'amount' => $plan->price,
            'recurring_amount' => $plan->price,
            'item_name' => $plan->name,
            'custom_str1' => "$organization->id",
            'custom_str2' => "$plan->id",
            'billing_date' => $nextBillingDate->format('Y-m-d'),
        ];

        $newPayFastService = new PayFastService();

        $this->payFastService =  $newPayFastService;

        $response = $newPayFastService->createPayment($paymentData);

        // dd($response);

        // Set the PayFast URL based on the environment
        $payfastUrl = \App::isProduction() ? 'https://www.payfast.co.za/eng/process' : 'https://sandbox.payfast.co.za/eng/process';

        // Remove empty values and sort the data array by key
        $data = $response;

        // Generate the HTML form with the data and automatically submit it
        $htmlForm = '<form id="payfast_form" action="'.$payfastUrl.'" method="POST">';
        foreach ($data as $name => $value) {
            $htmlForm .= '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars($value, ENT_QUOTES, 'UTF-8').'">';
        }
        $htmlForm .= '</form>';
        $htmlForm .= '<script type="text/javascript">document.getElementById("payfast_form").submit();</script>';

        return response($htmlForm);


        // return response()->json(['redirect_url' => $response['redirect_url']]);
    }

    /**
     * @OA\Get(
     *     path="/api/subscription/plans",
     *     tags={"Subscriptions"},
     *     summary="List all active subscription plans",
     *     description="Returns a list of all active subscription plans.",
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function showPlans()
    {
        $plans = SubscriptionPlan::where('status', 'Active')->get();

        return view('subscriptions.plans', compact('plans'));
    }

    /**
     * @OA\Get(
     *     path="/api/subscriptions",
     *     tags={"Subscriptions"},
     *     summary="Get current subscription details",
     *     description="Returns the current subscription details for the authenticated organization.",
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function show()
    {
        $organization = Auth::user()->organization;
        $subscription = $organization->subscriptions;

        return response()->json($subscription);
    }

    /**
     * @OA\Post(
     *     path="/api/subscriptions",
     *     tags={"Subscriptions"},
     *     summary="Subscribe to a new plan",
     *     description="Subscribes the authenticated organization to a new plan.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="plan_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Subscription created"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->input('plan_id'));
        $organization = Auth::user()->organization;

        // Handle payment and subscription activation
        $paymentData = [
            'amount' => $plan->price,
            'item_name' => $plan->name,
            'custom_str1' => $organization->id,
            'custom_str2' => $plan->id,
        ];

        $response = $this->payFastService->createPayment($paymentData);

        return response()->json(['redirect_url' => $response['redirect_url']]);
    }

    /**
     * @OA\Put(
     *     path="/api/subscriptions/cancel",
     *     tags={"Subscriptions"},
     *     summary="Cancel the current subscription",
     *     description="Cancels the current subscription for the authenticated organization.",
     *     @OA\Response(response=200, description="Subscription canceled successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function cancel(Request $request)
    {
        $organization = Auth::user()->organization;
        $subscription = $organization->subscriptions;

        $subscription->status = 'Canceled';
        $subscription->save();

        return redirect()->route('subscription.details')->with('success', 'Subscription canceled successfully.');
    }

    public function paymentNotify(Request $request)
    {
        // Log the PayFast notification for debugging purposes
        \Log::info('PayFast Payment Notification: ', $request->all());

        // Verify the signature and ensure the payment is legitimate
        $data = $request->all();

        $newPayFastService = new PayFastService();

        $signature = $newPayFastService->generateSignature($data);

        // Verify payment status
        if ($request->input('payment_status') === 'COMPLETE') {
            // Payment is successful
            $organizationId = $request->input('custom_str1'); // Assuming custom_str1 holds the organization ID
            $planId = $request->input('custom_str2'); // Assuming custom_str2 holds the subscription plan ID

            $subscriptionPlan = SubscriptionPlan::find($planId);
            $organization = Organization::find($organizationId);
            $subscription = Subscription::whereOrganizationId($organizationId);
            $nextDebitDate = $this->calculateNextBillingDate();
            if(!empty($subscription)){
                $subscription->update([
                    'end_date' => $nextDebitDate->format('Y-m-d'),
                    'status' => 'Active',
                ]);
            }else{
                $subscription = Subscription::create([
                    'subscription_plan_id' => $subscriptionPlan->id,
                    'start_date' => now(),
                    'end_date' => $nextDebitDate->format('Y-m-d'),
                    'status' => 'Active',
                ]);
            }

            $organization->update([
                'status' => 'Active',
            ]);

            Payment::create([
                'status' => 'Paid',
                'organization_id' => $organizationId,
                'subscription_id' => $subscription->id,
                'amount' => $request->input('amount_gross'),
                'pf_payment_id' => $request->input('pf_payment_id'),
                'token' => $request->input('token'),
            ]);

        } else {

            \Log::warning('Payment was not successful.');

        }

        return response('Notification received', 200);

        // return view('admin.dashboard')->with('message', 'Your payment was '.$request->input('payment_status'));
    }

    public function paymentRedirect(Request $request)
    {
        return redirect()->route('admin.dashboard')->with('message', 'Your payment was redirected.');
    }

    /**
     * @OA\Get(
     *     path="/subscriptions/success",
     *     tags={"Subscriptions"},
     *     summary="Handle payment success",
     *     description="Handles successful payment and returns a success message.",
     *     @OA\Response(response=200, description="Subscription activated successfully"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function paymentSuccess(Request $request)
    {
        return view('subscriptions.success')->with('message', 'Your subscription has been activated successfully!');
    }

    /**
     * @OA\Get(
     *     path="/subscriptions/cancel",
     *     tags={"Subscriptions"},
     *     summary="Handle payment cancellation",
     *     description="Handles payment cancellation and returns a cancellation message.",
     *     @OA\Response(response=200, description="Payment was canceled"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function paymentCancel(Request $request)
    {
        return view('admin.dashboard')->with('message', 'Your payment was canceled.');
    }

    private function calculateNextBillingDate()
    {
        $currentDate = now();

        return $currentDate->day < $currentDate->daysInMonth
                ? $currentDate->copy()->endOfMonth()
                : $currentDate->copy()->addMonthNoOverflow()->endOfMonth();

    }
}
