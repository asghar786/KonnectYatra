<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteToGalleryTable extends Migration
{
    public function up()
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->text('note')->nullable()->after('caption');
        });
    }

    public function down()
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
