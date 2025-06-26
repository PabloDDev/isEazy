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
     * Executes the product sale operation.
     *
     * @param SaleData $sale
     * @return array{
     *     success: bool,
     *     message: string,
     *     remaining_stock?: int
     * }
     */
    public function handle(SaleData $sale): array
    {
        return $this->productRepository->sellProduct($sale);
    }
}
