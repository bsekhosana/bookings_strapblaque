<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'organization_id',
        'subscription_type',
        'subscription_start_date',
        'subscription_end_date',
        'max_bookings',
        'status',
    ];

    const SUBSCRIPTION_TYPES = ['Trial', 'Basic', 'Startup', 'Premium', 'Enterprise'];

    const STATUSES = ['Active', 'Inactive', 'Suspended'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            $organization->slug = Str::random(12);
        });
    }
}
