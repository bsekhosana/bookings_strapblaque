<?php

namespace App\Http\Requests\Admin;

use App\Abstracts\CustomRequest;
use App\Rules\ValidEmail;
use Illuminate\Validation\Rule;

class UserRequest extends CustomRequest
{
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
     * Get the store validation rules.
     *
     * @return array<string, array>
     */
    public function createRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => ['bail', 'required', 'email', 'max:255', new ValidEmail(true), Rule::unique('users', 'email')],
            'avatar'     => ['nullable', 'image', 'max:5120'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get the update validation rules.
     *
     * @return array<string, array>
     */
    public function updateRules(): array
    {
        /** @var \App\Models\User $user */
        $user = $this->route('user');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => ['bail', 'required', 'email', 'max:255', new ValidEmail(true), Rule::unique('users', 'email')->ignoreModel($user)],
            'avatar'     => ['nullable', 'image', 'max:5120'],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
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
