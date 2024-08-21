<?php

namespace App\Http\Controllers\Api;

use App\Abstracts\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:user_api']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $user->exists
            ? $this->respondOk($user)
            : $this->respondNotFound('User not found!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Show user details that is making the request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function self(Request $request)
    {
        return $this->respondOk($request->user());
    }
}
