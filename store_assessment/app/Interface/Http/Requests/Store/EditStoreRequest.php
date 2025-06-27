<?php

namespace App\Interface\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates input for editing a store.
 *
 * @property int $store_id
 * @property string $name
 * @property string|null $description
 * @property array|null $products
 */
class EditStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_id' => 'required|integer|exists:stores,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string|max:500'
        ];
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (
                !$this->filled('name') &&
                !$this->filled('description') &&
                !$this->filled('products')
            ) {
                $validator->errors()->add(
                    'update_fields',
                    'At least one of the following fields must be provided: name or description'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'store_id.required' => 'The store ID is required.',
            'store_id.integer' => 'The store ID must be an integer.',
            'store_id.exists' => 'The specified store does not exist.',

            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must not exceed 500 characters.',

            'products.array' => 'The products must be an array.',

            'products.*.id.required_with' => 'Each product must have an ID.',
            'products.*.id.integer' => 'Each product ID must be an integer.',
            'products.*.id.exists' => 'Some products do not exist.',

            'products.*.quantity.required_with' => 'Each product must include a quantity.',
            'products.*.quantity.integer' => 'Product quantities must be integers.',
            'products.*.quantity.min' => 'Quantities must be at least 1.',

            'update_fields.required' => 'At least one of name, description, or products is required.',
        ];
    }
}