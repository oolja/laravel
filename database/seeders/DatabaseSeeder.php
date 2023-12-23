<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
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
        //TODO seed category_item pivot table
        User::factory(10)
            ->has(
                Restaurant::factory()
                    ->count(2)
                    ->has(Category::factory()->count(10)
                        ->has(Item::factory()->count(5))
                    )
            )
            ->create();

//        $this->call([
//            UserSeeder::class,
//            RestaurantSeeder::class,
//            CategorySeeder::class,
//            ItemSeeder::class
//        ]);
    }
}
