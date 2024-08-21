<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(Setting::class, 'setting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $settings = Setting::latest('id')->paginate();
        $settings->loadCrudRoutes();

        return view('admin.settings.index')->with(compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $setting = Setting::create($request->validated());

        \Alert::crud($setting, \Alert::Stored, 'setting');

        return redirect()->route('admin.settings.show', $setting);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Setting $setting)
    {
        return view('admin.settings.show')->with(compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Setting $setting)
    {
        $setting->withCrudRoutes();

        return view('admin.settings.edit')->with(compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        $updated = $setting->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'setting');

        return redirect()->route('admin.settings.show', $setting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Setting $setting)
    {
        $deleted = $setting->delete();

        \Alert::crud($deleted, \Alert::Deleted, 'setting');

        return redirect()->route('admin.settings.index');
    }
}
