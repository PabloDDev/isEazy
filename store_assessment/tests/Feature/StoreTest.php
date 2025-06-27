<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Persistence\Eloquent\Models\User;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    private const INDEX_ENDPOINT  = '/api/v1/stores';
    private const CREATE_ENDPOINT = '/api/v1/stores/create';
    private const UPDATE_ENDPOINT = '/api/v1/stores/update';
    private const SHOW_ENDPOINT   = '/api/v1/stores/show';
    private const DELETE_ENDPOINT = '/api/v1/stores/delete';

    protected function authenticate(): void
    {
        Sanctum::actingAs(User::factory()->create());
    }

    #[Test]
    public function it_creates_a_store_with_products(): void
    {
        $this->authenticate();

        $payload = [
            'name' => 'New Store',
            'description' => 'Store description',
            'products' => [
                ['name' => 'Product A', 'stock' => 10],
                ['name' => 'Product B', 'stock' => 5],
            ],
        ];

        $response = $this->postJson(self::CREATE_ENDPOINT, $payload);

        $response->assertCreated()
                 ->assertJsonStructure([
                     'id', 'name', 'description', 'products',
                 ]);
    }

    #[Test]
    public function it_fails_to_create_store_without_name(): void
    {
        $this->authenticate();

        $response = $this->postJson(self::CREATE_ENDPOINT, [
            'description' => 'Missing name',
        ]);

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function it_lists_all_stores(): void
    {
        $this->authenticate();

        $this->postJson(self::CREATE_ENDPOINT, [
            'name' => 'Store One',
            'products' => [['name' => 'Item X', 'stock' => 3]],
        ]);

        $this->postJson(self::CREATE_ENDPOINT, [
            'name' => 'Store Two',
            'products' => [['name' => 'Item Y', 'stock' => 7]],
        ]);

        $response = $this->getJson(self::INDEX_ENDPOINT);

        $response->assertOk()
                 ->assertJsonStructure([
                     '*' => ['id', 'name', 'product_count'],
                 ]);
    }

    #[Test]
    public function it_gets_store_details_by_id(): void
    {
        $this->authenticate();

        $createResponse = $this->postJson(self::CREATE_ENDPOINT, [
            'name' => 'Details Store',
            'products' => [['name' => 'Detail Product', 'stock' => 2]],
        ]);

        $storeId = $createResponse->json('id');
        $this->assertNotNull($storeId);

        $response = $this->postJson(self::SHOW_ENDPOINT, [
            'store_id' => $storeId,
        ]);

        $response->assertOk()
                 ->assertJsonStructure([
                     'id', 'name', 'description', 'products',
                 ]);
    }

    #[Test]
    public function it_updates_store_name_and_description(): void
    {
        $this->authenticate();

        $createResponse = $this->postJson(self::CREATE_ENDPOINT, [
            'name' => 'Original Name',
            'description' => 'Original description',
        ]);

        $storeId = $createResponse->json('id');
        $this->assertNotNull($storeId);

        $updatePayload = [
            'store_id' => $storeId,
            'name' => 'Updated Name',
            'description' => 'Updated description',
        ];

        $response = $this->postJson(self::UPDATE_ENDPOINT, $updatePayload);

        $response->assertOk()
                 ->assertJsonFragment(['message' => 'Store updated successfully']);
    }

    #[Test]
    public function it_deletes_a_store(): void
    {
        $this->authenticate();

        $createResponse = $this->postJson(self::CREATE_ENDPOINT, [
            'name' => 'Store to Delete',
            'products' => [['name' => 'Trash', 'stock' => 1]],
        ]);

        $storeId = $createResponse->json('id');
        $this->assertNotNull($storeId);

        $response = $this->deleteJson(self::DELETE_ENDPOINT, [
            'store_id' => $storeId,
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['message' => 'Store deleted successfully']);

        $this->postJson(self::SHOW_ENDPOINT, [
            'store_id' => $storeId,
        ])->assertUnprocessable()
        ->assertJsonValidationErrors(['store_id']);
    }
}
