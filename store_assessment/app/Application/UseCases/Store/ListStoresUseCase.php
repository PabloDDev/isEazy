<?php

namespace App\Application\UseCases\Store;

use App\Domain\Repositories\StoreRepositoryInterface;

/**
 * Retrieves all stores with their product counts.
 */
class ListStoresUseCase
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepository
    ) {}
    
    /**
     * Returns a list of all stores and the number of products each one has.
     *
     * @return iterable A collection of stores with product counts
     */
    public function handle(): iterable
    {
        return $this->storeRepository->allWithProductCount();
    }
}
