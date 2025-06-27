<?php

namespace App\Interface\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handles validation for deleting a store via JSON body.
 */
class FindStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'store_id' => 'required|integer|exists:stores,id',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'store_id.required' => 'The store ID is required.',
            'store_id.integer'  => 'The store ID must be a valid integer.',
            'store_id.exists'   => 'The specified store ID does not exist.',
        ];
    }
}