<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutes = [
            ['short_name' => 'آی تک', 'full_name' => 'آموزشگاه فنی و حرفه ای آزاد آی تک', 'abbr' => 'ITC', 'remain_credit' => 10000],
            ['short_name' => 'آی کد', 'full_name' => 'آموزشگاه برنامه نویسی آی کد', 'abbr' => 'ICD', 'remain_credit' => 10000],
            ['short_name' => 'مشرق', 'full_name' => 'آموزشگاه مجازی برنامه نویسی مشرق زمین', 'abbr' => 'MSH', 'remain_credit' => 100],
        ];
        foreach ($institutes as $data) {
            Institute::create($data);
        }
    }
}
