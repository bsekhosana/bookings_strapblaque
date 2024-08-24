<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrganizationSetting extends CrudAuthModel
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'slug',
        'primary_color',
        'secondary_color',
        'logo_small',
        'logo_large',
        'time_zone',
        'appointment_duration',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($setting) {
            $setting->slug = Str::random(12);
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }
}
