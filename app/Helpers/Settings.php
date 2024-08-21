<?php

namespace App\Helpers;

class Settings
{
    /** @var string ARRAY */
    const ARRAY = 'array';

    /** @var string BOOL */
    const BOOL = 'bool';

    /** @var string CURRENCY */
    const CURRENCY = 'currency';

    /** @var string DATE */
    const DATE = 'date';

    /** @var string DATETIME */
    const DATETIME = 'datetime';

    /** @var string FLOAT */
    const FLOAT = 'float';

    /** @var string INTEGER */
    const INTEGER = 'integer';

    /** @var string JSON */
    const JSON = 'json';

    /** @var string OBJECT */
    const OBJECT = 'object';

    /** @var string SERIALIZE */
    const SERIALIZE = 'serialize';

    /** @var string STRING */
    const STRING = 'string';

    /** @var string TIMESTAMP */
    const TIMESTAMP = 'timestamp';

    /**
     * Supported data types.
     *
     * @var array<string, string>
     */
    public static array $types = [
        self::ARRAY     => 'Array',
        self::BOOL      => 'Bool',
        self::CURRENCY  => 'Currency',
        self::DATE      => 'Date',
        self::DATETIME  => 'DateTime',
        self::FLOAT     => 'Float',
        self::INTEGER   => 'Integer',
        self::JSON      => 'JSON',
        self::OBJECT    => 'Object',
        self::SERIALIZE => 'Serialize',
        self::STRING    => 'String',
        self::TIMESTAMP => 'Timestamp',
    ];

    /**
     * Get value for a key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return \Cache::rememberForever(self::cacheKey($key), function () use ($key) {
            return \App\Models\Setting::where('key', $key)->first()?->value;
        }) ?? $default;
    }

    /**
     * Update value for key.
     */
    public static function update(string $key, mixed $value = null): bool|int
    {
        return \App\Models\Setting::where('key', $key)
            ->firstOrFail(['id', 'type', 'key'])
            ->update(compact('value'));
    }

    /**
     * Force-cache the specified setting.
     */
    public static function cache(string $key): void
    {
        \Cache::forget(self::cacheKey($key));

        self::get($key);
    }

    /**
     * Convert string to correct data type for logic purposes.
     */
    public static function convert(?string $value = null, string $type = 'string'): mixed
    {
        if (empty($value)) {
            return null;
        }

        switch ($type) {
            case self::ARRAY:
            case self::JSON:
                return json_decode($value, true);

            case self::BOOL:
                return boolval($value);

            case self::CURRENCY:
                return number_format(floatval($value), 2);

            case self::DATE:
            case self::DATETIME:
            case self::TIMESTAMP:
                return \Carbon\Carbon::parse($value);

            case self::FLOAT:
                return floatval($value);

            case self::INTEGER:
                return intval($value);

            case self::OBJECT:
                return json_decode($value, false);

            case self::SERIALIZE:
                return unserialize($value);

            case self::STRING:
            default:
                return strval($value);
        }
    }

    /**
     * Stringify data for DB insert or display purposes.
     */
    public static function stringify(mixed $value, string $type = 'string'): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Nova infinite parsing fix
        if (is_string($value) && $type != 'string') {
            return $value;
        }

        switch ($type) {
            case self::ARRAY:
                return json_encode((array) $value, JSON_PRETTY_PRINT);

            case self::BOOL:
                return boolval($value) ? '1' : '0';

            case self::CURRENCY:
                return number_format(floatval($value), 2);

            case self::DATE:
                return is_string($value) ? \Carbon\Carbon::parse($value)->toDateString() : $value->toDateString();

            case self::DATETIME:
            case self::TIMESTAMP:
                return is_string($value) ? \Carbon\Carbon::parse($value)->toDateTimeString() : $value->toDateTimeString();

            case self::FLOAT:
                return strval(floatval($value));

            case self::INTEGER:
                return strval(intval($value));

            case self::JSON:
                return json_encode($value, JSON_PRETTY_PRINT);

            case self::OBJECT:
                return json_encode((object) $value, JSON_PRETTY_PRINT);

            case self::SERIALIZE:
                return serialize($value);
        }

        try {
            $value = strval($value);
        } catch (\Exception $exception) {
            $value = null;
        }

        return $value;
    }

    /**
     * Cache key.
     */
    private static function cacheKey(string $key): string
    {
        return sprintf('settings:%s', \Str::slug($key, '_'));
    }
}
