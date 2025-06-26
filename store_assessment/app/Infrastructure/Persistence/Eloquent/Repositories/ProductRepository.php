<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Domain\DTOs\SaleData;

class ProductRepository implements ProductRepositoryInterface
{
    public function sellProduct(SaleData $sale): array
    {
        return DB::transaction(function () use ($sale) {
            $pivot = DB::table('store_product')
                ->where('store_id', $sale->storeId)
                ->where('product_id', $sale->productId)
                ->lockForUpdate()
                ->first();

            if (!$pivot) {
                return [
                    'success' => false,
                    'message' => 'Product not found in this store.'
                ];
            }

            if ($pivot->quantity < $sale->quantity) {
                return [
                    'success' => false,
                    'message' => 'Insufficient stock.'
                ];
            }

            $newQuantity = $pivot->quantity - $sale->quantity;

            DB::table('store_product')
                ->where('store_id', $sale->storeId)
                ->where('product_id', $sale->productId)
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