<?php

namespace App\Domain\Repositories;

interface ProductRepositoryInterface
{
    /**
     * Retrieves current product quantity from the store.
     *
     * @param int $storeId
     * @param int $productId
     * @return int|null
     */
    public function getProductStockInStore(int $storeId, int $productId): ?int;

    /**
     * Attempts to reduce product stock in a store within a transaction.
     *
     * @param int $storeId
     * @param int $productId
     * @param int $amount
     * @return bool Whether the operation succeeded
     */
    public function reduceProductStock(int $storeId, int $productId, int $amount): bool;
}
