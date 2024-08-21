<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmail implements ValidationRule
{
    /**
     * Check MX record in DNS for hostname.
     */
    protected bool $check_dns = false;

    /**
     * Create a new rule instance.
     */
    public function __construct(bool $check_dns = false)
    {
        $this->check_dns = $check_dns;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! \App\Helpers\Validate::email($value, $this->check_dns)) {
            $fail(
                $this->check_dns
                    ? 'Invalid email address or email server doesn\'t exist.'
                    : 'The :attribute must be a valid email address.'
            );
        }
    }
}
