<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('zip_codes')) {
            Schema::create('zip_codes', function (Blueprint $table) {
                // US ZIP -> city/state + centroid, used by the gurdwara ZIP search.
                // Seeded from database/data/us_zip_codes.csv (ZipCodesSeeder).
                $table->char('zip', 5)->primary();
                $table->string('city', 100);
                $table->char('state', 2);
                $table->decimal('lat', 8, 4);
                $table->decimal('lng', 9, 4);
                $table->index(['city', 'state']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('zip_codes');
    }
};
