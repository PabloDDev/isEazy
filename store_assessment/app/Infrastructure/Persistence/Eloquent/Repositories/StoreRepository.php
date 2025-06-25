<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\StoreRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Application\DTOs\ProductData;
use Illuminate\Support\Facades\DB;

class StoreRepository implements StoreRepositoryInterface
{
    public function listStoresWithProductCount(): iterable
    {
        return Store::withCount('products')->get();
    }

    public function getStoreWithProducts(int $id): ?object
    {
        $store = Store::with('products')->find($id);
        if (!$store) {
            return null;
        }

        $products = $store->products->map(fn($product) =>
            new ProductData(
                id: $product->id,
                name: $product->name,
                stock: $product->pivot?->quantity
            )
        );

        return (object)[
            'id' => $store->id,
            'name' => $store->name,
            'description' => $store->description,
            'products' => $products,
        ];
    }

    public function create(array $data, array $products = []): object
    {
        return DB::transaction(function () use ($data, $products) {
            $store = Store::create($data);

            if (!empty($products)) {
                $pivotData = collect($products)->mapWithKeys(function ($item) {
                    return [
                        $item['id'] => ['quantity' => $item['quantity']]
                    ];
                })->toArray();

                $store->products()->attach($pivotData);
            }

            return $store->load('products');
        });
    }

    public function update(int $id, array $data): bool
    {
        $store = Store::findOrFail($id);
        return $store->update($data);
    }

    public function delete(int $id): bool
    {
        $store = Store::findOrFail($id);
        return $store->delete();
    }
}