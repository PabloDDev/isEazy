<?php

namespace App\Application\DTOs;

/**
 * DTO representing a product.
 */
class ProductDTO
{
    /**
     * @param int $id
     * @param string $name
     * @param int|null $stock Optional (for store pivot quantity)
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?int $stock = null
    ) {}
}