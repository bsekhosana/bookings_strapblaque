<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class SettingCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! strlen($value)) {
            return null;
        }

        return \Settings::convert($value, $attributes['type']);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     * @throws \Exception
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        if (! isset($attributes['type'])) {
            throw new \Exception('No "type" specified. Place the "type" attribute first in the array when creating.');
        }

        return \Settings::stringify($value, $attributes['type']);
    }
}
