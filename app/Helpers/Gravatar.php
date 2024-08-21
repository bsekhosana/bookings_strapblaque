<?php

namespace App\Helpers;

class Gravatar
{
    /**
     * Gravatar domain name.
     * (Gravatar has a few different domains).
     */
    protected static string $domain = 's.gravatar.com';

    /**
     * Local avatar placeholder.
     */
    protected static string $placeholder = '/images/placeholders/avatar.png';

    /**
     * Get Gravatar avatar URL.
     *
     * @link https://en.gravatar.com/site/implement/images
     */
    public static function get(?string $email, int $size = 256, string $fallback = 'mp'): string
    {
        if (! $email) {
            return self::$placeholder;
        }

        $md5 = self::isHashed($email) ? $email : md5(strtolower($email));

        return sprintf('https://%s/avatar/%s?s=%d&d=%s', self::$domain, $md5, $size, $fallback);
    }

    /**
     * Check if avatar URL is Gravatar.
     */
    public static function isGravatar(?string $email = null): bool
    {
        return $email ? \Str::contains($email, self::$domain) : false;
    }

    /**
     * Check if email is already md5 hashed.
     */
    private static function isHashed(string $email): bool
    {
        return strlen($email) === 32 && ! \Str::contains($email, '@');
    }
}
