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
}