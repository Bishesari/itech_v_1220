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
            ['institute_id' => null, 'branch_id' => null, 'user_id' => 1,  'role_id' => 1],
            ['institute_id' => null, 'branch_id' => null, 'user_id' => 1,  'role_id' => 2],
            ['institute_id' => 1, 'branch_id' => null, 'user_id' => 2,  'role_id' => 3],
            ['institute_id' => 1, 'branch_id' => 1, 'user_id' => 1,  'role_id' => 10],
            ['institute_id' => 1, 'branch_id' => 2, 'user_id' => 1,  'role_id' => 10],
            ['institute_id' => 2, 'branch_id' => 4, 'user_id' => 1,  'role_id' => 10],
            ['institute_id' => 3, 'branch_id' => 6, 'user_id' => 3,  'role_id' => 10],
        ];
        foreach ($user_roles as $data) {
            InstituteUser::create($data);
        }
    }
}
