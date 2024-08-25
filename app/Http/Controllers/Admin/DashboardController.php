<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {

        $admin = auth()->user(); // Assuming the admin is authenticated
        $organization = $admin->organizations()->first();

        if ($organization) {
            if ($organization->status === 'Active') {
                if(count($organization->services) == 0){
                    return redirect()->route('admin.organization.services');
                }
                // Proceed to the dashboard
                return view('admin.dashboard');
            } elseif ($organization->status === 'Pending Activation') {
                // Redirect to activation screen
                return redirect()->route('admin.organization.activation');
            }
        }

        // If no organization or other cases
        return redirect()->route('admin.showRegForm')->withErrors(['msg' => 'Organization status is '.$organization->status.', please contact super admin if you wish to re activate it.']);
    }
}
