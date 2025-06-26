<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\StoreRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\DTOs\ProductData;
use App\Domain\DTOs\StoreData;
use Illuminate\Support\Facades\DB;

class StoreRepository implements StoreRepositoryInterface
{
    public function listStoresWithProductCount(): array
    {
        return Store::withCount('products')->get()->map(function ($store) {
            return new StoreData(
                id: $store->id,
                name: $store->name,
                description: $store->description,
                products: [],
                productCount: $store->products_count
            );
        })->toArray();
    }

    public function getStoreWithProducts(int $id): ?storeData
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

        return new StoreData(
            id: $store->id,
            name: $store->name,
            description: $store->description,
            products: $products
        );
    }

    public function create(array $data, array $products = []): storeData
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

            $productData = $store->products->map(fn($product) =>
                new ProductData(
                    id: $product->id,
                    name: $product->name,
                    stock: $product->pivot?->quantity
                )
            )->toArray();

            return new StoreData(
                id: $store->id,
                name: $store->name,
                description: $store->description,
                products: $productData,
                productCount: $store->products->count()
            );
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