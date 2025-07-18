<?php

namespace App\Interface\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\DTOs\ProductData;

/**
 * Formats the response for a store object.
 */
class StoreResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'products' => array_map(function (ProductData $product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->stock,
                ];
            }, $this->products)
        ];
    }
}