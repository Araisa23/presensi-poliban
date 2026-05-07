<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenaga_kependidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nama');
            $table->foreignId('unit_kerja_id')->constrained('unit_kerjas')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::table('tenaga_kependidikans', function (Blueprint $table) {
        $table->boolean('face_registered')->default(false);
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenaga_kependidikans');
        Schema::table('tenaga_kependidikans', function (Blueprint $table) {
        $table->dropColumn('face_registered');
    });
    }
};
