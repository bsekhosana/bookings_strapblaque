<?php

namespace App\Http\Requests;

use App\Abstracts\CustomRequest;
use App\Rules\OtpRule;
use Illuminate\Foundation\Auth\User;

class OtpRequest extends CustomRequest
{
    protected ?User $user = null;

    /**
     * 1. Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        //$this->merge(['key' => 'value']);
    }

    /**
     * 2. Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user = \App\Helpers\Auth::user($this);
    }

    /**
     * Get the store validation rules.
     *
     * @return array<string, array>
     */
    public function createRules(): array
    {
        return [
            'otp' => ['required', 'integer', 'min:102030', 'max:998877', new OtpRule($this->user)],
        ];
    }

    /**
     * Get the update validation rules.
     *
     * @return array<string, array>
     */
    public function updateRules(): array
    {
        return [];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'otp' => 'OTP does not match the code sent to you.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'otp' => 'OTP',
        ];
    }

    /**
     * Manipulate the validated data before storing and/or updating.
     *
     * @param  array<string, mixed>  $validated
     */
    protected function allData(array &$validated): void
    {
        //
    }

    /**
     * Manipulate the validated data before storing.
     *
     * @param  array<string, mixed>  $validated
     */
    protected function createData(array &$validated): void
    {
        //
    }

    /**
     * Manipulate the validated data before updating.
     *
     * @param  array<string, mixed>  $validated
     */
    protected function updateData(array &$validated): void
    {
        //
    }

    /**
     * Get the validated data from the request.
     *
     * @param  string|int|array|null  $key
     * @param  mixed  $default
     * @return array<string, mixed>|mixed
     */
    public function validated($key = null, $default = null): mixed
    {
        // This function is for click reference only!
        // Use `allData`, `createData` and `updateData`.
        return parent::validated($key, $default);
    }
}
