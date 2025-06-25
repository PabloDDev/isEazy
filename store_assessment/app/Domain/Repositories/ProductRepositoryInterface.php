<?php

namespace App\Domain\Repositories;

interface ProductRepositoryInterface
{
    public function sellProduct(int $storeId, int $productId, int $amount = 1): array;
}
