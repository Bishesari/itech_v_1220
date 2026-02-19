<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['user_name' => 'Yasser', 'password' => '123456'],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
