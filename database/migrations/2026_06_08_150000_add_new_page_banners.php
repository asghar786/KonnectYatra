<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNewPageBanners extends Migration
{
    public function up()
    {
        $now = now();
        $rows = [
            ['page_key' => 'gallery',           'label' => 'Gallery'],
            ['page_key' => 'pakistan-hotels',   'label' => 'Pakistan Hotels'],
            ['page_key' => 'popular-locations', 'label' => 'Popular Locations'],
        ];
        foreach ($rows as $r) {
            $exists = DB::table('page_banners')->where('page_key', $r['page_key'])->exists();
            if (!$exists) {
                DB::table('page_banners')->insert([
                    'page_key'   => $r['page_key'],
                    'label'      => $r['label'],
                    'image'      => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down()
    {
        DB::table('page_banners')
            ->whereIn('page_key', ['gallery', 'pakistan-hotels', 'popular-locations'])
            ->delete();
    }
}
