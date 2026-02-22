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
        ];
        foreach ($cities as $data) {
            City::create($data);
        }
    }
}
