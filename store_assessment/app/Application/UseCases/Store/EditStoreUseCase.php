<?php

namespace App\Application\UseCases\Store\Stores;

use App\Domain\Repositories\StoreRepositoryInterface;

/**
 * Handles updating an existing store.
 */
class EditStoreUseCase
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepository
    ) {}
    
    /**
     * Updates store attributes (e.g., name, description).
     *
     * @param int $id Store ID
     * @param array $data Fields to update
     * @return bool True if update succeeded
     */
    public function handle(int $id, array $data): bool
    {
        return $this->storeRepository->update($id, $data);
    }
}
