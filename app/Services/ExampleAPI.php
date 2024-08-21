<?php

namespace App\Services;

class ExampleAPI
{
    /**
     * @return \App\Services\ApiClient
     */
    private static function api()
    {
        return app(self::class);
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function ping()
    {
        return self::api()->get('/api/ping');
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function getUsers()
    {
        return self::api()->get('/api/example/users');
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function getUser(string $id)
    {
        return self::api()->get(sprintf('/api/example/users/%s', $id));
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function updateUser(string $id, array $data)
    {
        return self::api()->put(sprintf('/api/example/users/%s', $id), $data);
    }
}
