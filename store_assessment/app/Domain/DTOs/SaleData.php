<?php

namespace App\Domain\DTOs;

/**
 * DTO representing a product and the quantity to be used in a sale or store operation.
 */
class SaleData
{
    /**
     * @param int $id The product ID
     * @param int $quantity The quantity involved in the operation
     */
    public function __construct(
        public readonly int $id,
        public readonly int $quantity
    ) {}
}