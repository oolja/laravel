<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(
                Restaurant::factory()
                    ->count(2)
                    ->has(Category::factory()->count(10))
            )
            ->create();

//        $this->call([
//            UserSeeder::class,
//            RestaurantSeeder::class,
//            CategorySeeder::class
//        ]);
    }
}
