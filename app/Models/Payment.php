<?php

namespace App\Models;

use App\Abstracts\CrudModel;
use App\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends CrudModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'organization_id',
        'subscription_id',
        'status',
        'amount',
        'token',
        'pf_payment_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::random(12);
        });
    }

    /**
     * Subscription statuses.
     *
     * @var array
     */
    public static $statuses = [
        'Pending'                         => 'Pending',
        'Paid'                            => 'Paid',
        'Declined'                        => 'Declined',
        'Cancelled'                       => 'Cancelled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * The model's default attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        //
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'response_data' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function organization()
    {

        return $this->belongsTo(Organization::class);

    }

    public function subscription()
    {

        return $this->belongsTo(Subscription::class);

    }
}
