<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutes = [
            [
                'short_name' => 'آی تک',
                'full_name' => 'آموزشگاه فنی و حرفه ای آزاد آی تک',
                'abbr' => 'ITC',
                'slug' => 'i-tech',
            ],
            [
                'short_name' => 'آی کد',
                'full_name' => 'آموزشگاه برنامه نویسی آی کد',
                'abbr' => 'ICD',
                'slug' => 'i-code',
            ],
            [
                'short_name' => 'مشرق',
                'full_name' => 'آموزشگاه مجازی برنامه نویسی مشرق زمین',
                'abbr' => 'MSH',
                'slug' => 'mashreq',
            ],
        ];

        foreach ($institutes as $data) {
            Institute::create($data);
        }
    }
}
