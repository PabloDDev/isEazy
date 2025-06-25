<?php

namespace App\Application\DTOs;

class StoreData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly array $products = []
    ) {}
}