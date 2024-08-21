<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ValidRSAID implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! \App\Helpers\RSAID::validate($value)) {
            $fail('Invalid RSA ID number.');
        }
    }
}
