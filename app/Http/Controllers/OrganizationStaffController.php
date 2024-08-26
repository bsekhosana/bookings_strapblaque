<?php

namespace App\Http\Controllers;

use App\Models\OrganizationStaff;
use Illuminate\Http\Request;

class OrganizationStaffController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(OrganizationStaff::class, 'organizationStaff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $organizationStaffs = OrganizationStaff::latest('id')->paginate();
        $organizationStaffs->loadCrudRoutes();

        return view('admin.organizationStaffs.index')->with(compact('organizationStaffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.organizationStaffs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'is_bookable' => 'required|string|max:255',
            'title' => 'nullable|string',
            'organization_id' => 'required|string',
        ]);

        // Create a new service
        $staff = OrganizationStaff::create([
            'organization_id' => $validatedData['organization_id'], // Assuming user is linked to an organization
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'mobile' => $validatedData['mobile'],
            'email' => $validatedData['email'],
            'is_bookable' => $validatedData['is_bookable'],
            'organization_title' => $validatedData['title'],
        ]);

        // Return success response for AJAX
        return response()->json(['success' => true, 'staff' => $staff], 201);

        // $organizationStaff = OrganizationStaff::create($request->validated());

        // \Alert::crud($organizationStaff, \Alert::Stored, 'organizationStaff');

        // return redirect()->route('admin.organizationStaffs.show', $organizationStaff);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrganizationStaff  $organizationStaff
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(OrganizationStaff $organizationStaff)
    {
        return view('admin.organizationStaffs.show')->with(compact('organizationStaff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganizationStaff  $organizationStaff
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(OrganizationStaff $organizationStaff)
    {
        return view('admin.organizationStaffs.edit')->with(compact('organizationStaff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationStaff  $organizationStaff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OrganizationStaff $organizationStaff)
    {
        $updated = $organizationStaff->update($request->validated());

        \Alert::crud($updated, \Alert::Updated, 'organizationStaff');

        return redirect()->route('admin.organizationStaffs.show', $organizationStaff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganizationStaff  $organizationStaff
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(OrganizationStaff $organizationStaff)
    {
        \Log::info('Deleting OrganizationStaff with ID: ' . $organizationStaff->id);

        \Log::info($organizationStaff);

        $deleted = $organizationStaff->delete();

        if ($deleted) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete staff'], 500);
        }
    }

    public function destroyStaff( $organizationId)
    {
        \Log::info('Deleting OrganizationStaff with ID: ' . $organizationId);

        $organizationStaff = OrganizationStaff::find($organizationId);

        \Log::info($organizationStaff);

        $deleted = $organizationStaff->delete();

        if ($deleted) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete staff'], 500);
        }
    }
}
