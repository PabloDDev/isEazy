<?php

namespace App\Domain\Repositories;
use App\Domain\DTOs\SaleData;

/**
 * Handles product-related persistence logic.
 */
interface ProductRepositoryInterface
{
    /**
     * Sell a product by decreasing stock in a given store.
     *
     * @param SaleData $sale
     * @return array{
     *     success: bool,
     *     message: string,
     *     remaining_stock?: int
     * }
     */
    public function sellProduct(SaleData $sale): array;
}
