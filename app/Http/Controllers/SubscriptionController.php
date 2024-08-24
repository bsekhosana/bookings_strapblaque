<?php

namespace App\Http\Controllers;

use App\Models\Organization;
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
        $plans = SubscriptionPlan::where('status', 'Active')->get();

        return view('admin.organizations.activation', compact('plans'));
    }

    public function activateOrganization(Request $request)
    {


        return response()->json(['redirect_url' => $response['redirect_url']]);
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

    /**
     * @OA\Post(
     *     path="/api/subscriptions/initiate-payment",
     *     tags={"Subscriptions"},
     *     summary="Initiate payment for a subscription plan",
     *     description="Initiates payment for a subscription plan and redirects to the payment gateway.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="plan_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=302, description="Redirect to payment gateway"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function initiatePayment(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->input('plan_id'));
        $organization = Auth::user()->organization;

        $paymentData = [
            'amount' => $plan->price,
            'item_name' => $plan->name,
            'custom_str1' => $organization->id,
            'custom_str2' => $plan->id,
        ];

        $response = $this->payFastService->createPayment($paymentData);

        // Redirect to PayFast payment URL
        return redirect($response['redirect_url']);
    }

    /**
     * @OA\Post(
     *     path="/api/subscriptions/payment-notify",
     *     tags={"Subscriptions"},
     *     summary="Handle payment notifications",
     *     description="Handles payment notifications from the payment gateway.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="payment_status", type="string", example="COMPLETE"),
     *             @OA\Property(property="custom_str1", type="string", example="1"),
     *             @OA\Property(property="custom_str2", type="string", example="1"),
     *             @OA\Property(property="signature", type="string", example="abc123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Payment notification processed"),
     *     @OA\Response(response=400, description="Invalid signature"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function paymentNotify(Request $request)
    {
        // Log the PayFast notification for debugging purposes
        \Log::info('PayFast Payment Notification: ', $request->all());

        // Verify the signature and ensure the payment is legitimate
        $data = $request->all();
        $signature = $this->payFastService->generateSignature($data);

        if ($signature !== $request->input('signature')) {
            \Log::warning('PayFast signature mismatch. Payment not processed.');

            return response('Invalid signature', 400);
        }

        // Verify payment status
        if ($request->input('payment_status') === 'COMPLETE') {
            // Payment is successful
            $organizationId = $request->input('custom_str1'); // Assuming custom_str1 holds the organization ID
            $planId = $request->input('custom_str2'); // Assuming custom_str2 holds the subscription plan ID

            $subscriptionPlan = SubscriptionPlan::find($planId);
            $organization = Organization::find($organizationId);

            if ($subscriptionPlan && $organization) {
                // Update or create the subscription
                $subscription = Subscription::updateOrCreate(
                    ['organization_id' => $organization->id],
                    [
                        'subscription_plan_id' => $subscriptionPlan->id,
                        'start_date' => now(),
                        'end_date' => now()->addDays($subscriptionPlan->duration_in_days),
                        'status' => 'Active',
                    ]
                );

                \Log::info('Subscription updated successfully for organization ID: '.$organizationId);
            }
        } else {
            \Log::warning('Payment was not successful.');
        }

        return response('Payment notification processed', 200);
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
        return view('subscriptions.cancel')->with('message', 'Your payment was canceled.');
    }
}
