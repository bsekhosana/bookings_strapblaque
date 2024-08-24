<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubscriptionPlan extends CrudAuthModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'max_bookings',
        'has_sms_notifications',
        'has_email_notifications',
        'price',
        'duration_in_days',
        'status',
    ];

    const STATUSES = ['Active', 'Inactive'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            $plan->slug = Str::random(12);
        });
    }
}
