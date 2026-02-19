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
        ];
        foreach ($profiles as $profile) {
            Profile::create($profile);
        }
    }
}
