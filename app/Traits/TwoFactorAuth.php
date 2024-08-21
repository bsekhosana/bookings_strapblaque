<?php

namespace App\Traits;

trait TwoFactorAuth
{
    /**
     * Check if user has 2FA enabled.
     */
    public function tfaEnabled(): bool
    {
        return config('app.tfa') && ($this->tfa ?? false);
    }

    /**
     * Check if user needs to enter OTP.
     */
    public function hasOTP(): bool
    {
        return $this->tfaEnabled() && ($this->tfa_otp ?? false);
    }

    /**
     * Send OTP if 2FA is enabled.
     */
    public function sendOTP(): void
    {
        if ($this->tfaEnabled()) {
            \App\Helpers\OTP::notify($this);
        }
    }
}
