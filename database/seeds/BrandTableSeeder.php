<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder {
    public function run() {
        // создать 10 брендов
        App\Models\Brand::factory()->count(10)->create();
    }
}
