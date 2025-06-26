<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Persistence\Eloquent\Models\Store;
use App\Infrastructure\Persistence\Eloquent\Models\Product;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        for ($i = 1; $i <= 10; $i++) {
            $store = Store::create([
                'name' => 'Store ' . $i,
                'description' => 'Description for Store ' . $i,
            ]);

            // Randomly select 5–15 products to attach
            $storeProducts = $products->random(rand(5, 15))->pluck('id')->mapWithKeys(function ($productId) {
                return [$productId => ['quantity' => rand(1, 20)]];
            });

            $store->products()->attach($storeProducts);
        }
    }
}