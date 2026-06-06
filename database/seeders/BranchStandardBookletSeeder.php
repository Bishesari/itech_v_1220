<?php

namespace Database\Seeders;

use App\Models\BookletPrice;
use App\Models\Branch;
use App\Models\BranchStandardBooklet;
use App\Models\Standard;
use Illuminate\Database\Seeder;

class BranchStandardBookletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::first();

        $standard = Standard::first();

        $booklet = BranchStandardBooklet::create([
            'branch_id' => $branch->id,
            'standard_id' => $standard->id,
            'title' => 'جزوه لاراول',
            'description' => 'جزوه آموزشی استاندارد لاراول',
            'is_active' => true,
        ]);

        BookletPrice::create([
            'branch_standard_booklet_id' => $booklet->id,
            'price' => 250000,
            'valid_from' => now(),
        ]);
    }
}
