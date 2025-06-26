<?php

namespace App\Application\UseCases\Product;

use App\Domain\DTOs\SaleData;
use App\Domain\Repositories\ProductRepositoryInterface;

/**
 * Handles the sale of a product from a store.
 */
class SellProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    /**
     * Handles product sale decision logic.
     */
    public function handle(SaleData $sale): array
    {
        $stock = $this->productRepository->getProductStockInStore(
            $sale->storeId,
            $sale->productId
        );

        if (!$stock) {
            return [
                'success' => false,
                'message' => 'Product not found in this store.'
            ];
        }

        if ($stock < $sale->quantity) {
            return [
                'success' => false,
                'message' => 'Insufficient stock.'
            ];
        }

        $success = $this->productRepository->safelyReduceProductStock(
            $sale->storeId,
            $sale->productId,
            $sale->quantity
        );

        if (!$success) {
            return [
                'success' => false,
                'message' => 'Transaction failed — possibly due to a race condition.'
            ];
        }

        $remaining = $stock - $sale->quantity;

        return [
            'success' => true,
            'message' => $remaining <= 5
                ? 'Sale completed. Warning: stock is low.'
                : 'Sale completed successfully.',
            'remaining_stock' => $remaining
        ];
    }
}
