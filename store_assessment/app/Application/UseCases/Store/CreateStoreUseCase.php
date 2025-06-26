<?php

namespace App\Application\UseCases\Store;

use App\Domain\DTOs\StoreData;
use App\Domain\Repositories\StoreRepositoryInterface;

class CreateStoreUseCase
{

    /**
     * Handles the creation of a new store with optional product inventory.
     */
    public function __construct(
        protected StoreRepositoryInterface $storeRepository
    ) {}
    

    /**
     * Creates a new store and optionally attaches products with quantities.
     *
     * @param StoreData $data
     * @return object The created store model
     */
    public function handle(StoreData $data): object
    {
        return $this->storeRepository->create([
            'name' => $data->name,
            'description' => $data->description,
        ], $data->products);
    }
}