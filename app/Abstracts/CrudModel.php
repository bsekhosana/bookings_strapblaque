<?php

namespace App\Abstracts;

use App\Traits\CrudRoutes;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

abstract class CrudModel extends Model
{
    use CrudRoutes, Searchable;
}
