<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\StoreRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class StoreRepository implements StoreRepositoryInterface
{
    public function listAllWithProductCount(): iterable
    {
        return Store::withCount('products')->get();
    }

    public function findWithProducts(int $id): ?object
    {
        return Store::with(['products' => function ($query) {
            $query->select('products.id', 'name', 'price')
                  ->withPivot('quantity');
        }])->find($id);
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