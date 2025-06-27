<?php

namespace App\Application\UseCases\Store;

use App\Domain\Repositories\StoreRepositoryInterface;

/**
 * Handles the deletion of a store.
 */
class DeleteStoreUseCase
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepository
    ) {}
    
     /**
     * Deletes the store by ID.
     *
     * @param int $id Store ID
     * @return bool True if deletion was successful
     */
    public function handle(int $id): bool
    {
        return $this->storeRepository->delete($id);
    }
}