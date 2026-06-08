<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFocusToGalleryTable extends Migration
{
    public function up()
    {
        Schema::table('gallery', function (Blueprint $table) {
            // Focal point as a percentage (0-100) used for object-position on thumbnails.
            $table->unsignedTinyInteger('focus_x')->default(50)->after('image');
            $table->unsignedTinyInteger('focus_y')->default(50)->after('focus_x');
        });
    }

    public function down()
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->dropColumn(['focus_x', 'focus_y']);
        });
    }
}
