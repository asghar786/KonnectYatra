<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\YatariPackage;
class YatriPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        YatariPackage::create([
            'month' => 'November 2023',
            'single_price' => '2590',
            'double_price' => '2390',
            'triple_price' => '2190',
        ]);
        YatariPackage::create([
            'month' => 'December 2023',
            'single_price' => '2990',
            'double_price' => '2790',
            'triple_price' => '2690',
        ]);
        YatariPackage::create([
            'month' => 'January 2024',
            'single_price' => '2990',
            'double_price' => '2790',
            'triple_price' => '2690',
        ]);
    }
}
