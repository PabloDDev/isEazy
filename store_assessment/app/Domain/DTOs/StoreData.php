<?php

namespace App\Application\DTOs;
use App\Domain\DTOs\ProductData;

class StoreData
{
    /**
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @param ProductData[] $products
     * @param int|null $productCount
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly array $products = [],
        public readonly ?int $productCount = null
    ) {}
}