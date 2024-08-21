<?php

namespace App\Helpers;

use Illuminate\Support\Lottery;

class RSAID
{
    /**
     * Check if RSA ID number is valid.
     *
     * @see https://www.westerncape.gov.za/general-publication/decoding-your-south-african-id-number-0
     */
    public static function validate(string $rsa_id): bool
    {
        $valid = strlen($rsa_id) === 13
            && preg_match('/([0-9][0-9])(([0][1-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))([0-9])([0-9]{3})([0-1])([8])([0-9])/', $rsa_id);

        if ($valid) {
            return \Str::substr($rsa_id, -1, 1) === self::checksum($rsa_id);
        }

        return false;
    }

    /**
     * Generate a random RSA ID number.
     *
     * @see https://www.westerncape.gov.za/general-publication/decoding-your-south-african-id-number-0
     */
    public static function random(int $min_age = 18, int $max_age = 70, int $count = 1): string|array
    {
        $min_year = self::minYear($max_age);
        $max_year = self::maxYear($min_age);

        $rsa_id = function () use ($min_year, $max_year): string {
            $year = \Str::substr(strval(mt_rand($min_year, $max_year)), 2, 2);
            $year = \Str::padLeft($year, 2, '0');
            $month = \Str::padLeft(strval(mt_rand(1, 12)), 2, '0');
            $day = \Str::padLeft(strval(mt_rand(1, 28)), 2, '0');
            $gender = strval(mt_rand(1000, 9999));
            $citizenship = Lottery::odds(1, 20)->winner(fn () => 1)->loser(fn () => 0)->choose();
            $a = '8';

            $rsa_id = $year.$month.$day.$gender.$citizenship.$a;

            return $rsa_id.self::checksum($rsa_id);
        };

        if ($count > 1) {
            for ($x = 1; $x <= $count; $x++) {
                $ids[] = $rsa_id();
            }

            return $ids;
        }

        return $rsa_id();
    }

    /**
     * Generate a checksum for RSA ID using the Luhn algorithm.
     *
     * @see https://www.westerncape.gov.za/general-publication/decoding-your-south-african-id-number-0
     */
    public static function checksum(string $rsa_id): string|false
    {
        if (strlen($rsa_id) > 12) {
            $rsa_id = \Str::substr($rsa_id, 0, 12);
        } elseif (strlen($rsa_id) < 12) {
            \Log::error(sprintf('RSA ID needs to be at least 12 characters to generate a checksum. [%s]', $rsa_id));

            return false;
        }

        $sum = 0;

        foreach (str_split(strrev($rsa_id)) as $i => $digit) {
            $sum += ($i % 2 == 0) ? array_sum(str_split($digit * 2)) : $digit;
        }

        return (string) ((10 - ($sum % 10)) % 10);
    }

    /**
     * Get gender from RSA ID number.
     */
    public static function gender(string $rsa_id): string
    {
        return ((int) \Str::substr($rsa_id, 6, 1)) >= 5 ? 'Male' : 'Female';
    }

    /**
     * Get title from RSA ID number.
     */
    public static function title(string $rsa_id): string
    {
        return self::gender($rsa_id) == 'Male' ? 'Mr' : 'Ms';
    }

    /**
     * Get date of birth from RSA ID number.
     *
     * @return \Carbon\Carbon
     */
    public static function dob(string $rsa_id, int $max_age = 99)
    {
        $year = \Str::substr($rsa_id, 0, 2);
        $month = \Str::substr($rsa_id, 2, 2);
        $day = \Str::substr($rsa_id, 4, 2);

        $dob = \Carbon\Carbon::parse(sprintf('20%s-%s-%s', $year, $month, $day));

        $century = $dob->isFuture() || $dob->isBefore(now()->subYears($max_age)) ? '19' : '20';

        return \Carbon\Carbon::parse(sprintf('%s%s-%s-%s', $century, $year, $month, $day));
    }

    /**
     * Get age from RSA ID number.
     */
    public static function age(string $rsa_id, int $max_age = 99): int
    {
        return self::dob($rsa_id, $max_age)->diffInYears(now());
    }

    /**
     * Check if age from RSA ID number is in a range.
     */
    public static function inAgeRange(string $rsa_id, int $min_age = 18, int $max_age = 95): bool
    {
        $age = self::age($rsa_id);

        return $age >= $min_age && $age <= $max_age;
    }

    /**
     * Get the min year for range.
     *
     * @return mixed
     */
    private static function minYear(int $max_age)
    {
        return once(function () use ($max_age): int {
            return intval(date('Y')) - $max_age;
        });
    }

    /**
     * Get the max year for range.
     *
     * @return mixed
     */
    private static function maxYear(int $min_age)
    {
        return once(function () use ($min_age): int {
            return intval(date('Y')) - $min_age;
        });
    }
}
