<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\OrganizationSettingsHelper;
use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use Illuminate\Http\Request;

class OrganizationSettingsController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(OrganizationSetting::class, 'organizationSetting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Use the helper function to get organization settings
        $organizationSettings = OrganizationSettingsHelper::getOrganizationSettings();
        $organizationSettings->loadCrudRoutes();

        return view('admin.organization_settings.index')->with(compact('organizationSettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.organization_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $organizationSetting = OrganizationSetting::create($request->validated());

        \Alert::crud($organizationSetting, \Alert::Stored, 'organizationSetting');

        return redirect()->route('admin.organization_settings.show', $organizationSetting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrganizationSetting  $organizationSetting
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(OrganizationSetting $organizationSetting)
    {
        return view('admin.organization_settings.show')->with(compact('organizationSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganizationSetting  $organizationSetting
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(OrganizationSetting $organizationSetting)
    {
        return view('admin.organization_settings.edit')->with(compact('organizationSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationSetting  $organizationSetting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OrganizationSetting $organizationSetting)
    {
        $updated = $organizationSetting->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'organizationSetting');

        return redirect()->route('admin.organization_settings.show', $organizationSetting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganizationSetting  $organizationSetting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(OrganizationSetting $organizationSetting)
    {
        $deleted = $organizationSetting->delete();

        \Alert::crud($deleted, \Alert::Deleted, 'organizationSetting');

        return redirect()->route('admin.organization_settings.index');
    }
}
