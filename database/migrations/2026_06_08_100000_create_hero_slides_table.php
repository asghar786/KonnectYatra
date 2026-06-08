<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHeroSlidesTable extends Migration
{
    public function up()
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();        // small text above title
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');                       // public-relative path
            $table->string('btn1_text')->nullable();
            $table->string('btn1_link')->nullable();
            $table->string('btn2_text')->nullable();
            $table->string('btn2_link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // Seed the 3 slides currently hard-coded on the homepage so nothing is lost.
        $now = now();
        $desc = 'Konnect Yatra is proud to be part of seva for Sikh pilgrims to Nankana Sahib yatra and other sacred Gurdwaras in Pakistan.';
        DB::table('hero_slides')->insert([
            ['eyebrow' => 'A Holy Journey To', 'title' => 'NANKANA SAHIB', 'description' => $desc, 'image' => 'assets/images2/96.jpg', 'btn1_text' => 'BOOK NOW', 'btn1_link' => 'all-packages', 'btn2_text' => 'READ MORE', 'btn2_link' => 'our-info', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['eyebrow' => 'A Holy Journey To', 'title' => 'KARTARPUR SAHIB', 'description' => $desc, 'image' => 'assets/images2/44.jpg', 'btn1_text' => 'BOOK NOW', 'btn1_link' => 'all-packages', 'btn2_text' => 'READ MORE', 'btn2_link' => 'our-info', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['eyebrow' => 'A Holy Journey To', 'title' => 'PANJA SAHIB', 'description' => $desc, 'image' => 'assets/images2/88.jpg', 'btn1_text' => 'BOOK NOW', 'btn1_link' => 'all-packages', 'btn2_text' => 'READ MORE', 'btn2_link' => 'our-info', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('hero_slides');
    }
}
