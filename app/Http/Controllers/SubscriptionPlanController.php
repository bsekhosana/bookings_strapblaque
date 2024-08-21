<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();

        return view('admin.subscription_plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscription_plans.create');
    }

    public function store(Request $request)
    {
        $plan = new SubscriptionPlan;
        $plan->name = $request->input('name');
        $plan->max_bookings = $request->input('max_bookings');
        $plan->has_sms_notifications = $request->input('has_sms_notifications', false);
        $plan->has_email_notifications = $request->input('has_email_notifications', true);
        $plan->price = $request->input('price');
        $plan->duration_in_days = $request->input('duration_in_days');
        $plan->status = $request->input('status');
        $plan->save();

        return redirect()->route('admin.subscription_plans.index');
    }

    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        return view('admin.subscription_plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->name = $request->input('name');
        $plan->max_bookings = $request->input('max_bookings');
        $plan->has_sms_notifications = $request->input('has_sms_notifications', false);
        $plan->has_email_notifications = $request->input('has_email_notifications', true);
        $plan->price = $request->input('price');
        $plan->duration_in_days = $request->input('duration_in_days');
        $plan->status = $request->input('status');
        $plan->save();

        return redirect()->route('admin.subscription_plans.index');
    }

    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.subscription_plans.index');
    }
}
