<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use App\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAdmin extends CrudAuthModel
{
    use HasFactory;

    protected $table = 'organization_admin';

    protected $fillable = [
        'admin_id',
        'organization_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
