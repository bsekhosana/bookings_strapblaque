<?php

namespace App\Abstracts;

use App\Traits\CrudRoutes;
use App\Traits\Searchable;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class CrudAuthModel extends Authenticatable
{
    use CrudRoutes, Searchable;
}
