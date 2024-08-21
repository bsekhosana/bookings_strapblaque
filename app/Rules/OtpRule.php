<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Auth\User;

class OtpRule implements ValidationRule
{
    /**
     * The user that's submitting their OTP.
     */
    protected ?User $user = null;

    /**
     * Create a new rule instance.
     */
    public function __construct(?User $user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (trim($value) != $this->user?->tfa_otp) {
            $fail('Incorrect OTP provided.');
        }
    }
}
