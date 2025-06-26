<?php

namespace App\Interface\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for selling a product from a store.
 *
 * @property int $store_id
 * @property int $product_id
 * @property int $quantity
 */
class SellProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_id' => 'required|integer|exists:stores,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}