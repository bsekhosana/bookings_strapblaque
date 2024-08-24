<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use App\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends CrudAuthModel
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'organization_id',
        'name',
        'duration',
        'price',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            $service->slug = Str::random(12);
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
