<?php

namespace App\Services;

class ApiClient
{
    /**
     * API client.
     *
     * @var \Illuminate\Http\Client\PendingRequest
     */
    protected $client;

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        if ($config['token'] ?? null) {
            $headers['Authorization'] = sprintf('Bearer %s', $config['token']);
        } elseif ($config['username'] ?? null) {
            $headers['Authorization'] = sprintf('Basic %s', base64_encode($config['username'].':'.$config['password']));
        }

        $this->client = \Http::withOptions([
            'base_uri'     => $config['url'],
            'debug'        => false,
            'verify'       => true,
            'version'      => 2.0,
            'headers'      => $headers,
            'read_timeout' => 300,
            'timeout'      => 600,
        ]);
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function get(string $uri, ?array $query = null)
    {
        return $this->client->get($uri, $query)->throw()->object();
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function post(string $uri, array $data = [])
    {
        return $this->client->post($uri, $data)->throw()->object();
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function put(string $uri, array $data = [])
    {
        return $this->client->put($uri, $data)->throw()->object();
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function patch(string $uri, array $data = [])
    {
        return $this->client->patch($uri, $data)->throw()->object();
    }

    /**
     * @return object
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function delete(string $uri, array $data = [])
    {
        return $this->client->delete($uri, $data)->throw()->object();
    }
}
