<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Domain\DTOs\SaleData;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProductStockInStore(int $storeId, int $productId): ?int
    {
        $pivot = DB::table('store_product')
            ->where('store_id', $storeId)
            ->where('product_id', $productId)
            ->lockForUpdate()
            ->value('quantity');

        return $pivot !== null ? (int)$pivot : null;
    }

    public function reduceProductStock(int $storeId, int $productId, int $quantity): bool
    {
        return DB::transaction(function () use ($storeId, $productId, $quantity) {
            $stock = DB::table('store_product')
                ->where('store_id', $storeId)
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->value('quantity');

            if ($stock === null || $stock < $quantity) {
                return false;
            }

            DB::table('store_product')
                ->where('store_id', $storeId)
                ->where('product_id', $productId)
                ->update(['quantity' => $stock - $quantity]);

            return true;
        });
    }
}