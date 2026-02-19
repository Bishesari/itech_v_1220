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
        ];
        foreach ($contactUser as $contact) {
            ContactUser::create($contact);
        }
    }
}
