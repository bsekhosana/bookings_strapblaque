<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class Http
{
    /**
     * Get the client IP from request.
     */
    public static function ip(?Request $request = null): string
    {
        $request ??= \URL::getRequest();

        $ip = $request->header('X-Forwarded-For')
            ?? $request->header('CF-Connecting-IP')
            ?? $request->ip()
            ?? '127.0.0.1';

        return explode(',', str_replace(' ', '', $ip))[0];
    }

    /**
     * Get the previous URL.
     */
    public static function previousUrl(?string $fallback_route = null, mixed ...$arguments): string
    {
        if ($fallback_route && \URL::getRequest()->fullUrl() == \URL::previous()) {
            return \URL::route($fallback_route, ...$arguments);
        }

        return \URL::previous();
    }

    public static function requestToArray(?Request $request = null): array
    {
        $request ??= \URL::getRequest();

        return [
            'Method'           => $request->method(),
            'URL'              => $request->fullUrl(),
            'Previous URL'     => $request->header('Referer'),
            'IP'               => $request->ip(),
            'Device'           => $request->userAgent(),
            'Has Session'      => $request->hasSession(),
            'Has Prev Session' => $request->hasPreviousSession(),
            'Body / Query'     => $request->toArray(),
        ];
    }

    public static function requestToString(?Request $request = null): string
    {
        $array = self::requestToArray($request ?? \URL::getRequest());
        $string = '';

        foreach ($array as $key => $value) {
            $string .= is_string($value)
                ? sprintf("%s: %s\n", $key, $value)
                : sprintf("%s: %s\n", $key, json_encode($value, JSON_PRETTY_PRINT));
        }

        return $string;
    }

    /**
     * Get HTTP status code of a URL.
     *
     * @throws \Exception
     */
    public static function statusCode(string $url): int
    {
        try {
            return \Http::head($url)->status();
        } catch (\Exception $exception) {
            \Log::notice($exception->getMessage());

            return 502;
        }
    }

    /**
     * See if URL is from the same domain.
     */
    public static function sameSite(string $needle, ?string $haystack = null): bool
    {
        $haystack ??= \Config::get('app.url');

        return parse_url($haystack, PHP_URL_HOST) == parse_url($needle, PHP_URL_HOST);
    }

    /**
     * Save referer and return it.
     */
    public static function referer(Request $request): ?string
    {
        if (\Session::has('visitor.referer')) {
            $referer = \Session::get('visitor.referer');
        } elseif ($referer = $request->header('Referer')) {
            if (self::sameSite($referer)) {
                $referer = null;
            } else {
                \Session::put('visitor.referer', $referer);
            }
        }

        return $referer;
    }

    /**
     * Save source and return it.
     */
    public static function source(Request $request): ?string
    {
        if (\Session::has('visitor.source')) {
            $source = \Session::get('visitor.source');
        } elseif ($source = $request->query('source')) {
            \Session::put('visitor.source', $source);
        }

        return $source;
    }

    /**
     * Check if current machine has an internet connection.
     */
    public static function hasInternet(): bool
    {
        $hosts = ['1.1.1.1', '8.8.8.8', '1.0.0.1', '8.8.4.4'];

        foreach ($hosts as $host) {
            if ($connected = @fsockopen($host, 443)) {
                fclose($connected);

                return true;
            }
        }

        return false;
    }
}
