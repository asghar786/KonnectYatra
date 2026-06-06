<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_banners', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('label');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        $now = now();
        $pages = [
            ['page_key' => 'all-packages', 'label' => 'All Packages'],
            ['page_key' => 'packages',     'label' => 'Package Detail'],
            ['page_key' => 'itinerary',    'label' => 'Airline Tickets / Itinerary'],
            ['page_key' => 'gurdwaras',    'label' => 'Gurdwaras'],
            ['page_key' => 'aboutus',      'label' => 'About Us'],
            ['page_key' => 'contactus',    'label' => 'Contact Us'],
            ['page_key' => 'our-info',     'label' => 'Our Info'],
            ['page_key' => 'visa-form',    'label' => 'Visa Form'],
            ['page_key' => 'payment',      'label' => 'Payment'],
            ['page_key' => 'thank-you',    'label' => 'Thank You'],
            ['page_key' => 'blogs',        'label' => 'Blogs'],
        ];
        foreach ($pages as &$p) {
            $p['image'] = null;
            $p['created_at'] = $now;
            $p['updated_at'] = $now;
        }
        DB::table('page_banners')->insert($pages);
    }

    public function down()
    {
        Schema::dropIfExists('page_banners');
    }
};
