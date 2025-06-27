<?php

namespace App\Interface\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreListResource extends JsonResource
{
    /**
     * Transform the resource into a summary array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_count' => $this->products_count ?? 0,
        ];
    }
}
