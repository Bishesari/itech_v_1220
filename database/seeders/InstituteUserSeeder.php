<?php

namespace Database\Seeders;

use App\Models\InstituteUser;
use Illuminate\Database\Seeder;

class InstituteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_roles = [

            ['institute_id' => null, 'branch_id' => null, 'user_id' => 1,  'role_id' => 2],
        ];
        foreach ($user_roles as $data) {
            InstituteUser::create($data);
        }
    }
}
