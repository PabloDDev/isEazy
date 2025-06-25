<?php

namespace App\Domain\Repositories;

interface StoreRepositoryInterface
{
    public function listStoresWithProductCount(): iterable;

    public function getStoreWithProducts(int $id): ?object;

    public function create(array $data, array $products = []): object;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}