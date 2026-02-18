<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            ['user_id' => '1', 'identifier_type' => 'national_id', 'n_code' => '2063531218', 'gender' => 'Male', 'f_name_fa' => 'یاسر', 'l_name_fa' => 'بیشه سری'],
            ['user_id' => '2', 'identifier_type' => 'national_id', 'n_code' => '3500984886', 'gender' => 'Female', 'f_name_fa' => 'ندا', 'l_name_fa' => 'بخشی زاده'],
            ['user_id' => '3', 'identifier_type' => 'national_id', 'n_code' => '3501151284', 'gender' => 'Female', 'f_name_fa' => 'سیده لیلا', 'l_name_fa' => 'امامی'],
        ];
        foreach ($profiles as $profile) {
            Profile::create($profile);
        }
    }
}
