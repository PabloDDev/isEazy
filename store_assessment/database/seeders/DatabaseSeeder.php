<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'iseazy@test.com',
            'password' => Hash::make('test2025'),
        ]);

        $this->call([
            ProductSeeder::class,
            StoreSeeder::class,
        ]);
    }
}
