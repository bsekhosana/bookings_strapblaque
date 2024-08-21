<?php

namespace App\Http\Controllers;

use App\Abstracts\ApiController;
use App\Models\Service;
use Illuminate\Http\Request;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $services = Service::orderBy('id')->paginate();

        return $this->respondOk($services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Service $service)
    {
        return $service->exists ? $this->respondOk($service) : $this->respondNotFound('Service not found!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Service $service)
    {
        //$service->update($request->validated());

        return $this->respondOk($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return $this->respondNoContent();
    }
}
