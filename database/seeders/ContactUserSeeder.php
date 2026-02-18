<?php

namespace Database\Seeders;

use App\Models\ContactUser;
use Illuminate\Database\Seeder;

class ContactUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactUser = [
            ['user_id' => 1, 'contact_id' => 1],
            ['user_id' => 1, 'contact_id' => 2, 'is_primary' => false],
            ['user_id' => 2, 'contact_id' => 3],
            ['user_id' => 2, 'contact_id' => 4, 'is_primary' => false],
            ['user_id' => 3, 'contact_id' => 5],
        ];
        foreach ($contactUser as $contact) {
            ContactUser::create($contact);
        }
    }
}
