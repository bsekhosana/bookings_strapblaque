<?php

// Example Controller for managing organizations

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('subscriptions')->get();

        return view('admin.organizations.index', compact('organizations'));
    }

    public function show($id)
    {
        $organization = Organization::with('subscriptions', 'bookings')->findOrFail($id);

        return view('admin.organizations.show', compact('organization'));
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);

        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->update($request->all());

        return redirect()->route('admin.organizations.index')->with('success', 'Organization updated successfully!');
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return redirect()->route('admin.organizations.index')->with('success', 'Organization deleted successfully!');
    }
}
