<?php

namespace App\Abstracts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class CustomRequest extends FormRequest
{
    /**
     * If this is an update (PUT) request.
     */
    protected bool $updating = false;

    /**
     * The data that was validated.
     */
    protected array $validated = [];

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
        $this->updating = $this->isMethod('PUT');

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array>
     */
    public function rules(): array
    {
        return $this->updating ? $this->updateRules() : $this->createRules();
    }

    /**
     * Get the store validation rules.
     *
     * @return array<string, array>
     */
    abstract public function createRules(): array;

    /**
     * Get the update validation rules.
     *
     * @return array<string, array>
     */
    abstract public function updateRules(): array;

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
     * Get the validated data from the request.
     *
     * @param  string|int|array|null  $key
     * @param  mixed  $default
     * @return array<string, mixed>|mixed
     */
    public function validated($key = null, $default = null): mixed
    {
        $this->validated = $this->validator->validated();

        $this->allData($this->validated);

        $this->updating
            ? $this->updateData($this->validated)
            : $this->createData($this->validated);

        return data_get($this->validated, $key, $default);
    }

    /**
     * Manipulate the validated data before storing and/or updating.
     *
     * @param  array<string, mixed>  $validated
     */
    abstract protected function allData(array &$validated): void;

    /**
     * Manipulate the validated data before storing.
     *
     * @param  array<string, mixed>  $validated
     */
    abstract protected function createData(array &$validated): void;

    /**
     * Manipulate the validated data before updating.
     *
     * @param  array<string, mixed>  $validated
     */
    abstract protected function updateData(array &$validated): void;

    /**
     * Handle a failed validation attempt.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        if (\App::hasDebugModeEnabled()) {
            if (function_exists('ray')) {
                ray('REQUEST DATA:', $this->validationData())->blue();
                ray('REQUEST ERRORS:', $validator->errors()->getMessages())->red();
            } elseif (function_exists('dd')) {
                dd(
                    'DATA:',
                    $this->validationData(),
                    'ERRORS:',
                    $validator->errors()->getMessages(),
                );
            }
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
