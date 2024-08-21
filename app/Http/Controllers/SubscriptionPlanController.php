<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\PayFastService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Subscription Plans",
 *     description="Operations related to subscription plans"
 * )
 */
class SubscriptionController extends Controller
{
    protected $payFastService;

    public function __construct(PayFastService $payFastService)
    {
        $this->payFastService = $payFastService;
    }

}
