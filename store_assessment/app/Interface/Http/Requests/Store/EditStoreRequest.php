<?php

namespace App\Http\Requests\Store;

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
            'description' => 'sometimes|nullable|string|max:500',
            'products' => 'sometimes|array',
            'products.*.id' => 'required_with:products|integer|exists:products,id',
            'products.*.quantity' => 'required_with:products|integer|min:1',
        ];
    }
}