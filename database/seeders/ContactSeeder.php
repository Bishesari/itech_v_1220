<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            ['contact_value' => '09177755924', 'type' => 'mobile', 'is_verified' => true],
        ];
        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
