<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenaga_kependidikans', function (Blueprint $table) {
            $table->dropColumn('face_registered');
        });
    }

    public function down(): void
    {
        Schema::table('tenaga_kependidikans', function (Blueprint $table) {
            $table->boolean('face_registered')->default(false);
        });
    }
};