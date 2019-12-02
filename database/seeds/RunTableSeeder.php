<?php

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;
use App\User;

class RunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $employee =  User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        for($i = 0; $i < 10; $i++){

            $supplier =  Supplier::create([
                'supplier' => $faker->company,
                'contact' => $faker->phoneNumber,
            ]);

            $category =  Category::create([
                'category' => $faker->colorName,
            ]);
        }

        for($i = 0; $i < 100; $i++){

            $supplier =  Product::create([
                'product' => $faker->word,
                'category_id' => $faker->numberBetween(1,10),
                'supplier_id' => $faker->numberBetween(1,10),
                'quantity' => $faker->numberBetween(1,50),
                'price' => $faker->numberBetween(99,999),
            ]);

        }

    }
}
