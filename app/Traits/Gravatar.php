<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait Gravatar
{
    /**
     * Get user's gravatar URL.
     */
    public function avatar(): Attribute
    {
        return Attribute::make(function (): string {
            return \Cache::tags('avatars')->rememberForever('avatars:'.md5($this->email), fn () => \Gravatar::get($this->email));
        })->shouldCache();
    }
}
