<?php

if (! function_exists('ray')) {
    /**
     * Fallback func when ray() is being used in a non-local environment.
     *
     * @return \Spatie\LaravelRay\Ray|\App\Helpers\Ray
     */
    function ray(...$args)
    {
        return (new \App\Helpers\Ray)->ray(...$args);
    }
}

if (! function_exists('diskImage')) {
    /**
     * Get image URL from a disk listed in filesystem config.
     *
     * @return string|null
     */
    function diskImage(?string $image, string $disk = 'public')
    {
        return \App\Helpers\Image::fromDisk($image, $disk);
    }
}

if (! function_exists('fileSizeStr')) {
    /**
     * Convert to human-readable size.
     *
     * @return string
     */
    function fileSizeStr(int $bytes = 0)
    {
        return \App\Helpers\Str::fileSize($bytes);
    }
}

if (! function_exists('truncateNumber')) {
    /**
     * Truncate number and append string. Eg. 1.23M followers.
     *
     * @return string
     */
    function truncateNumber(int $number, ?string $plural = null)
    {
        return \App\Helpers\Str::truncateNumber($number, $plural);
    }
}

if (! function_exists('truncateWords')) {
    /**
     * Truncate words for excerpts/blurbs.
     *
     * @param  int  $count
     * @return string|null
     */
    function truncateWords(?string $words, $count = 10)
    {
        return \App\Helpers\Str::truncateWords($words, $count);
    }
}

if (! function_exists('truncateString')) {
    /**
     * Truncate a string for excerpts/blurbs.
     *
     * @param  int  $length
     * @return string|null
     */
    function truncateString(?string $string, $length = 10)
    {
        return \App\Helpers\Str::truncateString($string, $length);
    }
}

if (! function_exists('randomString')) {
    /**
     * Random string with numbers, upper and lower case letters.
     *
     * @return string
     */
    function randomString(int $length = 60, bool $include_capitals = true, bool $include_numbers = true, bool $readable_only = false)
    {
        return \App\Helpers\Str::random($length, $include_capitals, $include_numbers, $readable_only);
    }
}

if (! function_exists('randomColor')) {
    /**
     * Random color hex code.
     *
     * @return string
     */
    function randomColor(bool $with_hash = false)
    {
        return \App\Helpers\Str::randomColor($with_hash);
    }
}

if (! function_exists('iconForBool')) {
    /**
     * Red/green bullet icon. (FontAwesome & Bootstrap dependant).
     *
     * @return string
     */
    function iconForBool(bool $bool, bool $marks = true)
    {
        return \App\Helpers\Str::iconForBool($bool, $marks);
    }
}

if (! function_exists('iconForExtension')) {
    /**
     * Get image for specified file extension.
     *
     * @return string
     */
    function iconForExtension(string $extension, bool $wrap_img_tag = false, ?string $style = null, ?string $class = null)
    {
        return \App\Helpers\Image::extension($extension, $wrap_img_tag, $style, $class);
    }
}

if (! function_exists('previousUrl')) {
    /**
     * Get the previous URL.
     *
     * @return string
     */
    function previousUrl(?string $fallback_route = null, mixed ...$arguments)
    {
        return \App\Helpers\Http::previousUrl($fallback_route, ...$arguments);
    }
}

if (! function_exists('urlStatusCode')) {
    /**
     * Get HTTP status code of a URL.
     *
     * @return int
     */
    function urlStatusCode(string $url)
    {
        return \App\Helpers\Http::statusCode($url);
    }
}

if (! function_exists('validRSAID')) {
    /**
     * Check if RSA ID number is valid.
     *
     * @return bool
     */
    function validRSAID(string $rsa_id)
    {
        return \App\Helpers\RSAID::validate($rsa_id);
    }
}

if (! function_exists('genderFromRSAID')) {
    /**
     * Get gender from RSA ID number.
     *
     * @return string
     */
    function genderFromRSAID(string $rsa_id)
    {
        return \App\Helpers\RSAID::gender($rsa_id);
    }
}

if (! function_exists('dobFromRSAID')) {
    /**
     * Get date of birth from RSA ID number.
     *
     * @return \Carbon\Carbon
     */
    function dobFromRSAID(string $rsa_id, int $max_age = 99)
    {
        return \App\Helpers\RSAID::dob($rsa_id, $max_age);
    }
}

if (! function_exists('ageFromRSAID')) {
    /**
     * Get age from RSA ID number.
     *
     * @return int
     */
    function ageFromRSAID(string $rsa_id, int $max_age = 99)
    {
        return \App\Helpers\RSAID::age($rsa_id, $max_age);
    }
}

if (! function_exists('inAgeRangeFromRSAID')) {
    /**
     * Check if age from RSA ID number is in a range.
     *
     * @return bool
     */
    function inAgeRangeFromRSAID(string $rsa_id, int $min_age = 18, int $max_age = 95)
    {
        return \App\Helpers\RSAID::inAgeRange($rsa_id, $min_age, $max_age);
    }
}
