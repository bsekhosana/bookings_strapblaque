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
}
