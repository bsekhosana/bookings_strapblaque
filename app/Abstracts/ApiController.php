<?php

namespace App\Abstracts;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;

abstract class ApiController extends Controller
{
    use ApiResponder;
}
