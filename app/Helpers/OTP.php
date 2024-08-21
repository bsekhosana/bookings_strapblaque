<?php

namespace App\Helpers;

use Illuminate\Foundation\Auth\User;

class OTP
{
    /**
     * DB column for 2FA bool.
     */
    private static string $tfa_column = 'tfa';

    /**
     * DB column for OTP number.
     */
    private static string $otp_column = 'tfa_otp';

    /**
     * DB column for email address to send OTP.
     */
    public static string $email_column = 'email';

    /**
     * DB column for mobile number to send OTP.
     */
    public static string $mobile_column = 'mobile';

    /**
     * Generate a new OTP.
     */
    public static function generate(): int
    {
        return mt_rand(102030, 998877);
    }

    /**
     * Force set a new OTP.
     */
    public static function set(User $user): int
    {
        $otp = self::generate();

        self::updateOtp($user, $otp);

        return $otp;
    }

    /**
     * Force clear the OTP.
     *
     * @throws \Exception
     */
    public static function clear(User $user): bool
    {
        return self::updateOtp($user);
    }

    /**
     * Send notification to User.
     */
    public static function notify(User $user): void
    {
        $tfa_col_exists = array_key_exists(self::$tfa_column, $user->getRawOriginal());

        if (! $tfa_col_exists || ($tfa_col_exists && $user->{self::$tfa_column})) {
            $otp = self::set($user);
            $user->refresh()->notify(new \App\Notifications\OTP($otp));
        }
    }

    /**
     * Update OTP in DB.
     */
    private static function updateOtp(User $user, ?int $otp = null): int
    {
        return \DB::table($user->getTable())
            ->where('id', $user->id)
            ->update([self::$otp_column => $otp]);
    }
}
