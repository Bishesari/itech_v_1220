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
        ];
        foreach ($provinces as $data) {
            Province::create($data);
        }
    }
}
