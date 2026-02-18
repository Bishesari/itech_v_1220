<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['province_id' => 1, 'name' => 'بوشهر', 'slug' => 'Bushehr'],
            ['province_id' => 1, 'name' => 'گناوه', 'slug' => 'Genaveh'],
            ['province_id' => 1, 'name' => 'برازجان', 'slug' => 'Borazjan'],
            ['province_id' => 2, 'name' => 'شیراز', 'slug' => 'Shiraz'],
            ['province_id' => 2, 'name' => 'مرودشت', 'slug' => 'Marvdasht'],
            ['province_id' => 3, 'name' => 'اصفهان', 'slug' => 'Isfahan'],
            ['province_id' => 3, 'name' => 'شهرضا', 'slug' => 'Shahreza'],
            ['province_id' => 4, 'name' => 'تهران', 'slug' => 'Tehran'],
        ];
        foreach ($cities as $data) {
            City::create($data);
        }
    }
}
