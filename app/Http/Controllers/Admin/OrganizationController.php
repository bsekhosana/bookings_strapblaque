<?php

// Example Controller for managing organizations

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Request;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="Operations related to managing organizations in the admin panel"
 * )
 */
class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/organizations",
     *     tags={"Organizations"},
     *     summary="List all organizations",
     *     description="Returns a list of all organizations in the system.",
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function index()
    {
        $organizations = Organization::with('subscriptions')->get();

        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * @OA\Post(
     *     path="/admin/organizations",
     *     tags={"Organizations"},
     *     summary="Create a new organization",
     *     description="Creates a new organization.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Organization Name"),
     *             @OA\Property(property="email", type="string", example="contact@organization.com")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Organization created"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $organization = Organization::create($request->all());
        return redirect()->route('admin.organizations.index')->with('success', 'Organization created successfully!');
    }

    /**
     * @OA\Get(
     *     path="/admin/organizations/{id}",
     *     tags={"Organizations"},
     *     summary="View an organization",
     *     description="Returns details of a specific organization.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Organization not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        $organization = Organization::with('subscriptions', 'bookings')->findOrFail($id);

        return view('admin.organizations.show', compact('organization'));
    }

    /**
     * @OA\Get(
     *     path="/admin/organizations/{id}/edit",
     *     tags={"Organizations"},
     *     summary="Edit an organization",
     *     description="Returns the edit view for a specific organization.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Organization not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        return view('admin.organizations.edit', compact('organization'));
    }

    /**
     * @OA\Put(
     *     path="/admin/organizations/{id}",
     *     tags={"Organizations"},
     *     summary="Update an organization",
     *     description="Updates the details of a specific organization.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Organization Name"),
     *             @OA\Property(property="email", type="string", example="updated@example.com"),
     *             @OA\Property(property="status", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Organization updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Organization not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->update($request->all());
        return redirect()->route('admin.organizations.index')->with('success', 'Organization updated successfully!');
    }

    /**
     * @OA\Delete(
     *     path="/admin/organizations/{id}",
     *     tags={"Organizations"},
     *     summary="Delete an organization",
     *     description="Deletes a specific organization.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Organization deleted successfully"),
     *     @OA\Response(response=404, description="Organization not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return redirect()->route('admin.organizations.index')->with('success', 'Organization deleted successfully!');
    }
}
