<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SellProductRequest;
use App\Application\UseCases\Product\SellProductUseCase;
use App\Domain\DTOs\SaleData;
use Illuminate\Http\JsonResponse;

/**
 * Handles product-related API actions.
 */
class ProductController extends Controller
{
    public function __construct(
        private SellProductUseCase $sellProduct
    ) {}

    /**
     * Sell a product from a store's inventory.
     *
     * @param SellProductRequest $request
     * @return JsonResponse
     */
    public function sell(SellProductRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $sale = new SaleData(
            storeId: $validated['store_id'],
            productId: $validated['product_id'],
            quantity: $validated['quantity']
        );

        $result = $this->sellProduct->handle($sale);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json([
            'message' => $result['message'],
            'remaining_stock' => $result['remaining_stock']
        ]);
    }
}