<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('yatri_documents')) {
            Schema::create('yatri_documents', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('yatri_visa_id')->index();
                $table->string('name');
                $table->string('file');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('yatri_documents');
    }
};
