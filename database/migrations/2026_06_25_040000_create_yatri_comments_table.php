<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('yatri_comments')) {
            Schema::create('yatri_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('yatri_visa_id')->index();
                $table->text('comment');
                $table->string('author')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('yatri_comments');
    }
};
