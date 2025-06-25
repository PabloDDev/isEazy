<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function sellProduct(int $storeId, int $productId, int $amount = 1): array
    {
        return DB::transaction(function () use ($storeId, $productId, $amount) {
            $pivot = DB::table('store_product')
                ->where('store_id', $storeId)
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->first();

            if (!$pivot) {
                return [
                    'success' => false,
                    'message' => 'Product not found in this store.'
                ];
            }

            if ($pivot->quantity < $amount) {
                return [
                    'success' => false,
                    'message' => 'Insufficient stock.'
                ];
            }

            $newQuantity = $pivot->quantity - $amount;

            DB::table('store_product')
                ->where('store_id', $storeId)
                ->where('product_id', $productId)
                ->update(['quantity' => $newQuantity]);

            return [
                'success' => true,
                'message' => $newQuantity <= 5
                    ? 'Sale completed. Warning: stock is low.'
                    : 'Sale completed successfully.',
                'remaining_stock' => $newQuantity
            ];
        });
    }
}