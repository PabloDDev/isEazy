<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Infrastructure\Persistence\Eloquent\Models\Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
