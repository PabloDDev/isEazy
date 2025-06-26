<?php

namespace App\Domain\Repositories;
use App\Domain\DTOs\StoreData;

interface StoreRepositoryInterface
{
    public function listStoresWithProductCount(): array;

    public function getStoreWithProducts(int $id): ?storeData;

    public function create(array $data, array $products = []): object;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}