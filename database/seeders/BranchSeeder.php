<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            ['institute_id' => 1, 'short_name' => 'شعبه مرکزی', 'code' => 'CEN', 'is_main' => true, 'province_id' => '1', 'city_id' => '1'],
            ['institute_id' => 1, 'short_name' => 'شعبه نیایش', 'code' => 'NIY', 'is_main' => false, 'province_id' => '1', 'city_id' => '1'],
            ['institute_id' => 1, 'short_name' => 'شعبه گناوه', 'code' => 'GNV', 'is_main' => false, 'province_id' => '1', 'city_id' => '2'],
            ['institute_id' => 2, 'short_name' => 'شعبه مرکزی', 'code' => 'CEN', 'is_main' => true, 'province_id' => '1', 'city_id' => '1'],
            ['institute_id' => 2, 'short_name' => 'شعبه برازجان', 'code' => 'BRJ', 'is_main' => false, 'province_id' => '1', 'city_id' => '3'],
            ['institute_id' => 3, 'short_name' => 'شعبه مرکزی', 'code' => 'CEN', 'is_main' => true, 'province_id' => '4', 'city_id' => '8'],
        ];
        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
