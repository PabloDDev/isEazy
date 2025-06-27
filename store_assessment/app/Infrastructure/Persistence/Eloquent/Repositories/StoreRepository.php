<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\StoreRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\DTOs\ProductData;
use App\Domain\DTOs\StoreData;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Persistence\Eloquent\Models\Product;

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
        )->toArray();

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

            $pivotData = [];

            foreach ($products as $p) {
                $product = Product::create([
                    'name' => $p->name,
                ]);

                $pivotData[$product->id] = ['quantity' => $p->stock];
            }

            if (!empty($pivotData)) {
                $store->products()->attach($pivotData);
            }

            $store->load('products');

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

    public function update(storeData $storeData): bool
    {
        $store = Store::findOrFail($storeData->id);
        
        return $store->update([
            'name' => $storeData->name,
            'description' => $storeData->description,
        ]);
    }

    public function delete(int $id): bool
    {
        $store = Store::findOrFail($id);
        return $store->delete();
    }
}