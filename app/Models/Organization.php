<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'email',
        'address',
        'phone',
        'status',
    ];

    const STATUSES = ['Active', 'Inactive', 'Suspended'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            $organization->slug = Str::random(12);
        });
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Define the relationship with Admin
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'organization_admin');
    }

    // Define the relationship with User
    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }
}
