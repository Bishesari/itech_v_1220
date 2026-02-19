<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['slug' => 'newbie',            'name' => 'تازه وارد',        'scope' => 'system',    'color' => 'blue',    'is_active' => true],
            ['slug' => 'super-admin',       'name' => 'سوپر ادمین',       'scope' => 'system',    'color' => 'red',      'is_active' => true],

            ['slug' => 'founder',           'name' => 'موسس',             'scope' => 'institute', 'color' => 'teal',   'is_active' => true],

            ['slug' => 'manager',           'name' => 'مدیر',             'scope' => 'branch',    'color' => 'indigo',   'is_active' => true],
            ['slug' => 'assistant',         'name' => 'مسئول اداری',      'scope' => 'branch',    'color' => 'fuchsia',  'is_active' => true],
            ['slug' => 'accountant',        'name' => 'حسابدار',          'scope' => 'branch',    'color' => 'orange',   'is_active' => true],
            ['slug' => 'teacher',           'name' => 'مربی',             'scope' => 'branch',    'color' => 'amber',    'is_active' => true],
            ['slug' => 'student',           'name' => 'کارآموز',          'scope' => 'branch',    'color' => 'lime',     'is_active' => true],
            ['slug' => 'marketer',          'name' => 'بازاریاب',         'scope' => 'branch',    'color' => 'green',    'is_active' => true],

            ['slug' => 'question-maker',    'name' => 'طراح سوال',        'scope' => 'institute', 'color' => 'purple',   'is_active' => true],
            ['slug' => 'question-auditor',  'name' => 'ممیز سوال',        'scope' => 'system',    'color' => 'violet',   'is_active' => true],
            ['slug' => 'examiner',          'name' => 'آزمونگر',          'scope' => 'system',    'color' => 'yellow',   'is_active' => true],

            ['slug' => 'job-seeker',        'name' => 'کارجو',            'scope' => 'system',    'color' => 'emerald',  'is_active' => true],
            ['slug' => 'examinee',          'name' => 'آزمون دهنده',      'scope' => 'system',    'color' => 'sky',      'is_active' => true],
            ['slug' => 'employer',          'name' => 'کارفرما',          'scope' => 'system',    'color' => 'cyan',     'is_active' => true],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
