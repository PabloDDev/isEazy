<?php

namespace App\Application\UseCases\Store;

use App\Domain\Repositories\StoreRepositoryInterface;
use App\Domain\DTOs\StoreData;

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
    public function handle(StoreData $store): bool
    {
        return $this->storeRepository->update($store);
    }
}
