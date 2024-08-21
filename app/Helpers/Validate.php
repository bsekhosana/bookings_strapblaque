<?php

namespace App\Helpers;

class Validate
{
    /**
     * Validate email address.
     *
     * @return bool
     * @throws \Exception
     */
    public static function email(string $email, bool $check_dns = false)
    {
        $valid = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);

        if ($valid && $check_dns) {
            if (! Http::hasInternet()) {
                throw new \Exception('No internet connection to verify DNS records.');
            }

            $hostname = explode('@', $email)[1];

            return checkdnsrr($hostname, 'MX');
        }

        return $valid;
    }

    /**
     * Validate URL address.
     *
     * @return bool
     * @throws \Exception
     */
    public static function url(string $url, bool $check_dns = false)
    {
        $valid = (bool) filter_var($url, FILTER_VALIDATE_URL);

        if ($valid && $check_dns) {
            if (! Http::hasInternet()) {
                throw new \Exception('No internet connection to verify DNS records.');
            }

            $hostname = parse_url($url, PHP_URL_HOST);

            return checkdnsrr($hostname, 'A') || checkdnsrr($hostname, 'AAAA');
        }

        return $valid;
    }
}
