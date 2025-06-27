<?php

namespace App\Domain\DTOs;

/**
 * DTO representing a product.
 */
class ProductData
{
    /**
     * @param int|null $id
     * @param string $name
     * @param int|null $stock Optional (for store pivot quantity)
     */
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?int $stock = null
    ) {}
}