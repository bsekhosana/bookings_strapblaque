<?php


namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Subscription;
use App\Services\PayFastService;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    protected $payFastService;

    public function __construct(PayFastService $payFastService)
    {
        $this->payFastService = $payFastService;
    }

    public function showPlans()
    {
        $plans = SubscriptionPlan::where('status', 'Active')->get();
        return view('subscriptions.plans', compact('plans'));
    }

    public function cancel(Request $request)
    {
        $organization = Auth::user()->organization;
        $subscription = $organization->subscriptions;

        $subscription->status = 'Canceled';
        $subscription->save();

        return redirect()->route('subscription.details')->with('success', 'Subscription canceled successfully.');
    }

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

                \Log::info('Subscription updated successfully for organization ID: ' . $organizationId);
            }
        } else {
            \Log::warning('Payment was not successful.');
        }

        return response('Payment notification processed', 200);
    }


    // Additional methods for handling payment success, cancellation, and notification...

    public function paymentSuccess(Request $request)
    {
        return view('subscriptions.success')->with('message', 'Your subscription has been activated successfully!');
    }

    public function paymentCancel(Request $request)
    {
        return view('subscriptions.cancel')->with('message', 'Your payment was canceled.');
    }


}
