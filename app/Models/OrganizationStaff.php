<?php

namespace App\Models;

use App\Abstracts\CrudAuthModel;
use App\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStaff extends CrudAuthModel
{
    use HasFactory;

    protected $table = 'organization_staff';

    protected $fillable = [
        'slug',
        'organization_title',
        'organization_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'is_bookable',
        'status'
    ];

    const STATUSES = ['Active', 'Suspended', 'On Leave', 'Deactivated'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::random(12);
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

}
