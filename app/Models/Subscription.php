<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use App\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends CrudAuthModel
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'organization_id',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            $subscription->slug = Str::random(12);
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'start_date'        => 'datetime',
        'end_date'        => 'datetime',
    ];

    const STATUSES = ['Pending', 'Active', 'Canceled', 'Expired'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
