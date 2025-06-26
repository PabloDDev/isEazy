<?php

namespace App\Application\UseCases\Store;

use App\Domain\Repositories\StoreRepositoryInterface;
use App\Domain\DTOs\StoreData;

/**
 * Fetches a store and its products with quantities.
 */
class GetStoreDetailsUseCase
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepository
    ) {}
    
    /**
     * Retrieves the store with related products and stock levels.
     *
     * @param int $id Store ID
     * @return object|null { id, name, description, products: ProductData[]
     */
    public function handle(int $id): ?storeData
    {
        return $this->storeRepository->getWithProducts($id);
    }
}