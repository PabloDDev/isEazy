<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Persistence\Eloquent\Models\User;
use App\Infrastructure\Persistence\Eloquent\Models\Product;
use App\Infrastructure\Persistence\Eloquent\Models\Store;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private const SELL_ENDPOINT = '/api/v1/products/sell';

    protected function authenticate(): void
    {
        Sanctum::actingAs(User::factory()->create());
    }

    #[Test]
    public function it_sells_a_product_successfully(): void
    {
        $this->authenticate();

        $store = Store::factory()->create();
        $product = Product::factory()->create();

        DB::table('store_product')->insert([
            'store_id' => $store->id,
            'product_id' => $product->id,
            'quantity' => 10,
        ]);

        $payload = [
            'store_id' => $store->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        $response = $this->postJson(self::SELL_ENDPOINT, $payload);

        $response->assertOk()
                 ->assertJson([
                     'message' => 'Sale completed successfully.',
                 ]);
    }

    #[Test]
    public function it_fails_to_sell_due_to_insufficient_stock(): void
    {
        $this->authenticate();

        $store = Store::factory()->create();
        $product = Product::factory()->create();

        DB::table('store_product')->insert([
            'store_id' => $store->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->postJson(self::SELL_ENDPOINT, [
            'store_id' => $store->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $response->assertStatus(400)
                 ->assertJson([
                     'message' => 'Insufficient stock.',
                 ]);
    }

    #[Test]
    public function it_fails_when_product_is_not_found_in_store(): void
    {
        $this->authenticate();

        $store = Store::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(self::SELL_ENDPOINT, [
            'store_id' => $store->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(400)
                 ->assertJson([
                     'message' => 'Product not found in this store.',
                 ]);
    }

    #[Test]
    public function it_fails_validation_with_missing_fields(): void
    {
        $this->authenticate();

        $response = $this->postJson(self::SELL_ENDPOINT, []);

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['store_id', 'product_id', 'quantity']);
    }
}
