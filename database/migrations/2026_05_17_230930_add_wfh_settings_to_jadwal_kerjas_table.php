<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_kerjas', function (Blueprint $table) {
            $table->boolean('is_wfh')->default(false);

            $table->boolean('use_camera')->default(true);

            $table->boolean('use_location')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_kerjas', function (Blueprint $table) {
            //
        });
    }
};
