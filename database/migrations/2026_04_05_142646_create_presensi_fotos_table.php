<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presensi_id')->constrained('presensis')->onDelete('cascade');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_fotos');
    }
};
