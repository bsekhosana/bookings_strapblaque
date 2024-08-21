<?php

namespace App\Http\Requests\Admin;

use App\Abstracts\CustomRequest;
use App\Rules\ValidEmail;
use Illuminate\Validation\Rule;
use InteractionDesignFoundation\GeoIP\Location;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;

class AdminRequest extends CustomRequest
{
    /**
     * Geolocation details from current request.
     */
    protected ?Location $geo = null;

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
        return true;
    }

    /**
     * 3. Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $this->geo = \GeoIP::getLocation($this->ip());

        return parent::getValidatorInstance();
    }

    /**
     * Get the store validation rules.
     *
     * @return array<string, array>
     */
    public function createRules(): array
    {
        return [
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['bail', 'required', 'email', 'max:255', new ValidEmail(true), 'unique:admins,email'],
            'mobile'      => ['required', (new Phone)->country($this->geo->iso_code)->mobile()],
            'tfa'         => ['required', 'boolean'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'super_admin' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the update validation rules.
     *
     * @return array<string, array>
     */
    public function updateRules(): array
    {
        /** @var \App\Models\Admin $admin */
        $admin = $this->route('admin');

        return [
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['bail', 'required', 'email', 'max:255', new ValidEmail(true), Rule::unique('admins', 'email')->ignoreModel($admin)],
            'mobile'      => ['required', (new Phone)->country($this->geo->iso_code)->mobile()],
            'tfa'         => ['required', 'boolean'],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
            'super_admin' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Manipulate the validated data before storing and/or updating.
     *
     * @param  array<string, mixed>  $validated
     */
    protected function allData(array &$validated): void
    {
        $validated['mobile'] = (new PhoneNumber($validated['mobile'], $this->geo->iso_code))->formatE164();
    }

    /**
     * Manipulate the validated data before storing.
     *
     * @param  array<string, mixed>  $validated
     */
    protected function createData(array &$validated): void
    {
        $validated['password'] = \Hash::make($validated['password']);
    }

    /**
     * Manipulate the validated data before updating.
     *
     * @param  array<string, mixed>  $validated
     */
    protected function updateData(array &$validated): void
    {
        if ($validated['password'] ?? null) {
            $validated['password'] = \Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
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
