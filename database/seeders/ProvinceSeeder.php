<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['name' => 'بوشهر', 'slug' => 'Bushehr'],
            ['name' => 'فارس', 'slug' => 'Fars'],
            ['name' => 'اصفهان', 'slug' => 'Isfahan'],
            ['name' => 'تهران', 'slug' => 'Tehran'],
        ];
        foreach ($provinces as $data) {
            Province::create($data);
        }
    }
}
