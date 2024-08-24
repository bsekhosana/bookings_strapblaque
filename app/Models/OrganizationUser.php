<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use App\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends CrudAuthModel
{
    use HasFactory;

    protected $table = 'organization_user';

    protected $fillable = [
        'user_id',
        'organization_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
