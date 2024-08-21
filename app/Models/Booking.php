<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'subscription_id',
        'service_id',
        'client_name',
        'client_email',
        'client_phone',
        'start_time',
        'end_time',
        'status',
    ];

    const STATUSES = ['Scheduled', 'Completed', 'Canceled'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
