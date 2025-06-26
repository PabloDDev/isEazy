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
     * @return StoreData[]
    */
    public function handle(): array
    {
        return $this->storeRepository->allWithProductCount();
    }
}
