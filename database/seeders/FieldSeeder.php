<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        Field::create(['title' => 'فناوری اطلاعات']);
        Field::create(['title' => 'امور مالی و بازرگانی']);
        Field::create(['title' => 'هنرهای تجسمی']);
    }
}
