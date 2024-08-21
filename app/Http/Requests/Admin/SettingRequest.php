<?php

namespace App\Http\Requests\Admin;

use App\Abstracts\CustomRequest;
use App\Models\Setting;
use Illuminate\Validation\Rule;

class SettingRequest extends CustomRequest
{
    /**
     * The setting being updated, if any.
     */
    protected ?Setting $setting = null;

    /**
     * 1. Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->setting = $this->route('setting');

        // If Setting is not editable, unset the value if it exists
        if (! $this->setting?->editable && $this->has('value')) {
            $this->offsetUnset('value');
        }
    }

    /**
     * 2. Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the store validation rules.
     *
     * @return array<string, array>
     */
    public function createRules(): array
    {
        return [];
    }

    /**
     * Get the update validation rules.
     *
     * @return array<string, array>
     */
    public function updateRules(): array
    {
        return [
            'type'     => ['bail', 'required', 'string', Rule::in(array_keys(\Settings::$types))],
            'editable' => ['required', 'boolean', 'in:0,1'],
            'comment'  => ['nullable', 'string', 'max:255'],
            'value'    => ['nullable', 'required_if:editable,1'],
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
        $validated['comment'] ??= null;

        // If Setting is not editable, unset the value if it exists
        if (! $this->setting->editable && isset($validated['value'])) {
            unset($validated['value']);
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
