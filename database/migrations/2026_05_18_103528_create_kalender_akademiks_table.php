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
        Schema::create('kalender_akademiks', function (Blueprint $table) {

            $table->id();

            $table->string('judul');

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai')->nullable();

            $table->enum('jenis', [
                'libur',
                'akademik',
                'ujian',
                'event'
            ]);

            $table->boolean('is_libur')->default(false);

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalender_akademiks');
    }
};
