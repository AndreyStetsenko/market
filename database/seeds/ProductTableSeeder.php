<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // создать 30 товаров
        App\Models\Product::factory()->count(30)->create();
    }
}
