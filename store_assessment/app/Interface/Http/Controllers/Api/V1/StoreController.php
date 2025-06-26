<?php

namespace App\Interface\Http\Controllers\Api\V1;

use App\Interface\Http\Controllers\Controller;
use App\Interface\Http\Requests\Store\CreateStoreRequest;
use App\Interface\Http\Requests\Store\FindStoreRequest;
use App\Interface\Http\Resources\Store\StoreResource;
use App\Interface\Http\Resources\Store\StoreListResource;
use App\Application\UseCases\Store\CreateStoreUseCase;
use App\Application\UseCases\Store\GetStoreUseCase;
use App\Application\UseCases\Store\ListStoresUseCase;
use App\Application\UseCases\Store\EditStoreUseCase;
use App\Application\UseCases\Store\DeleteStoreUseCase;
use App\Domain\DTOs\StoreData;
use App\Domain\DTOs\ProductData;
use Illuminate\Http\JsonResponse;

/**
 * Handles store-related API endpoints.
 */
class StoreController extends Controller
{
    public function __construct(
        private CreateStoreUseCase $createStore,
        private GetStoreUseCase $getStore,
        private ListStoresUseCase $listStores,
        private EditStoreUseCase $editStore,
        private DeleteStoreUseCase $deleteStore
    ) {}

    /**
     * List all stores with product count.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stores = $this->listStores->handle();
        return response()->json(StoreListResource::collection($stores));
    }

    /**
     * Show details of a specific store with its products.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(FindStoreRequest $request): JsonResponse
    {

        $storeId = $request->validated('store_id');

        $store = $this->getStore->handle($id);
        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        return response()->json(new StoreResource($store));
    }

    /**
     * Create a new store and optionally assign products.
     *
     * @param CreateStoreRequest $request
     * @return JsonResponse
     */
    public function store(CreateStoreRequest $request): JsonResponse
    {
        
        $validated = $request->validated();

        $products = collect($validated['products'] ?? [])
            ->map(fn($product) => new ProductData(
                id: $product['id'],
                name: $product['name'],
                stock: $product['quantity']
            ))
            ->all();

        $storeData = new StoreData(
            id: 0,
            name: $request->input('name'),
            description: $request->input('description'),
            products: $products
        );

        $created = $this->createStore->handle($storeData);

        return response()->json(new StoreResource($created), 201);
    }

    /**
     * Update store information.
     *
     * @param EditStoreRequest $request
     * @return JsonResponse
     */
    public function update(EditStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $storeData = new StoreData(
            id: $validated['store_id'],
            name: $validated['name'] ?? null,
            description: $validated['description'] ?? null,
            products: []
        );

        $success = $this->editStore->handle($storeData);

        if (!$success) {
            return response()->json(['message' => 'Store could not be updated'], 404);
        }

        return response()->json(['message' => 'Store updated successfully'], 200);
    }

    /**
     * Delete a store by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(FindStoreRequest $request): JsonResponse
    {
        $storeId = $request->validated('store_id');

        $success = $this->deleteStore->handle($storeId);

        if (!$success) {
            return response()->json(['message' => 'Store not found'], 404);
        }

        return response()->json(['message' => 'Store deleted successfully'], 200);
    }
}