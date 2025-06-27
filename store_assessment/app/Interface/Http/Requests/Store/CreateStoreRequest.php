<?php

namespace App\Interface\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handles validation for creating a store via API request.
 *
 * @property string $name
 * @property string|null $description
 * @property array|null $products
 */
class CreateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Always true for this test setup
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'products' => 'nullable|array',
            'products.*.name' => 'required|string',
            'products.*.stock' => 'required|integer|min:0',
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
            'name.required' => 'The store name is required.',
            'name.string' => 'The store name must be a string.',
            'name.max' => 'The store name must not exceed 255 characters.',

            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must not exceed 500 characters.',

            'products.array' => 'The products must be an array.',

            'products.*.name.required' => 'Each product must have a name.',
            'products.*.name.string' => 'Each product name must be a string.',
            'products.*.stock.required' => 'Each product must have a stock quantity.',
            'products.*.stock.integer' => 'Product stock must be an integer.',
        ];
    }
}