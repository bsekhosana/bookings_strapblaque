<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'duration',
        'price',
        'description',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
