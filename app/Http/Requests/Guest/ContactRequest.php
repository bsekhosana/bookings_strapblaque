<?php

namespace App\Http\Requests\Guest;

use App\Abstracts\CustomRequest;
use App\Rules\ValidEmail;
use InteractionDesignFoundation\GeoIP\Location;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;

class ContactRequest extends CustomRequest
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
            'name'    => ['required', 'string', 'min:2', 'max:255'],
            'email'   => ['required', 'email', 'min:6', 'max:255', new ValidEmail(true)],
            'mobile'  => ['nullable', (new Phone)->country($this->geo->iso_code)->mobile()],
            'subject' => ['nullable', 'min:4', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ];
    }

    /**
     * Get the update validation rules.
     *
     * @return array<string, array>
     */
    public function updateRules(): array
    {
        return [
            //
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
        $validated['name'] = ucwords($validated['name']);
        $validated['email'] = strtolower($validated['email']);
        $validated['subject'] = ($validated['subject'] ?? false) ? ucfirst($validated['subject']) : null;
        $validated['message'] = ucfirst($validated['message']);
        $validated['ip_address'] = \App\Helpers\Http::ip($this);

        if (! empty($validated['mobile'])) {
            $validated['mobile'] = (new PhoneNumber($validated['mobile'], $this->geo->iso_code))->formatE164();
        }
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
