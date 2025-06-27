<?php

namespace App\Domain\DTOs;

/**
 * Data transfer object for a sale.
 */
class SaleData
{
    public function __construct(
        public int $storeId,
        public int $productId,
        public int $quantity = 1
    ) {}
}