<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        $this->authorizeResource(Admin::class, 'admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Admin::search(function () {
            return Admin::where('id', '!=', \Auth::id())
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->paginate();
        }, 'admins');

        return view('admin.admins.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->validated());

        \Alert::crud($admin, \Alert::Stored, 'admin');

        return redirect()->route('admin.admins.show', $admin);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->validated());

        \Alert::crud($admin, \Alert::Stored, 'admin');

        return redirect()->route('admin.admins.show', $admin);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Admin $admin)
    {
        return view('admin.admins.show')->with(compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit')->with(compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $updated = $admin->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'admin');

        return redirect()->route('admin.admins.show', $admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Admin $admin)
    {
        $deleted = $admin->delete();

        \Alert::crud($deleted, \Alert::Deleted, 'admin');

        return redirect()->route('admin.admins.index');
    }
}
