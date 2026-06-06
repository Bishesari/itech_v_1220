<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        Field::create([
            'title' => 'فناوری اطلاعات',
            'slug' => 'information-technology',
        ]);

        Field::create([
            'title' => 'امور مالی و بازرگانی',
            'slug' => 'finance-and-commerce',
        ]);

        Field::create([
            'title' => 'هنرهای تجسمی',
            'slug' => 'visual-arts',
        ]);
    }
}
