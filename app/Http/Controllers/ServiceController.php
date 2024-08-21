<?php

namespace App\Http\Controllers;

use App\Abstracts\ApiController;
use App\Models\Service;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Service",
 *     description="Operations related to booking services"
 * )
 */
class ServiceController extends ApiController
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware(['auth:user_api']);
    }

    /**
     * @OA\Get(
     *     path="/api/services",
     *     tags={"Services"},
     *     summary="List all services",
     *     description="Returns a paginated list of all services.",
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function index()
    {
        $services = Service::orderBy('id')->paginate();

        return $this->respondOk($services);
    }

    /**
     * @OA\Post(
     *     path="/api/services",
     *     tags={"Services"},
     *     summary="Create a new service",
     *     description="Creates a new service.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Consultation"),
     *             @OA\Property(property="duration", type="integer", example=60),
     *             @OA\Property(property="price", type="number", format="float", example=100.00)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Service created successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function store(Request $request)
    {
        // Implementation for storing a service goes here
    }

    /**
     * @OA\Get(
     *     path="/api/services/{id}",
     *     tags={"Services"},
     *     summary="Get a specific service",
     *     description="Returns the details of a specific service.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function show(Service $service)
    {
        return $service->exists ? $this->respondOk($service) : $this->respondNotFound('Service not found!');
    }

    /**
     * @OA\Put(
     *     path="/api/services/{id}",
     *     tags={"Services"},
     *     summary="Update a service",
     *     description="Updates the details of a specific service.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Consultation"),
     *             @OA\Property(property="duration", type="integer", example=60),
     *             @OA\Property(property="price", type="number", format="float", example=120.00)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Service updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function update(Request $request, Service $service)
    {
        //$service->update($request->validated());

        return $this->respondOk($service);
    }

    /**
     * @OA\Delete(
     *     path="/api/services/{id}",
     *     tags={"Services"},
     *     summary="Delete a service",
     *     description="Deletes a specific service.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Service deleted successfully"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return $this->respondNoContent();
    }
}
