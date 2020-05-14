<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure table is empty before trying to seed
        if (DB::table('products')->count() !== 0) return;

        // Seed table differently depending on the environment
        if (App::environment('production')) {
            Product::create([
                'title' => 'Product #1',
                'description' => 'Product #1 Description',
                'price' => 0.75,
                'availability' => true
            ]);
        } else {
            $faker = \Faker\Factory::create();

            // Create 50 fake product records
            for ($i = 0; $i < 50; $i++) {
                Product::create([
                    'title' => $faker->title,
                    'description' => $faker->paragraph,
                    'price' => $faker->randomNumber(2),
                    'availability' => $faker->boolean(50)
                ]);
            }
        }
    }
}
