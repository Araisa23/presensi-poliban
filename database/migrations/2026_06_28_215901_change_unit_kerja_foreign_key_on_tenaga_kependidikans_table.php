<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenaga_kependidikans', function (Blueprint $table) {

            $table->dropForeign(['unit_kerja_id']);

            $table->foreign('unit_kerja_id')
                ->references('id')
                ->on('unit_kerjas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

        });
    }

    public function down(): void
    {
        Schema::table('tenaga_kependidikans', function (Blueprint $table) {

            $table->dropForeign(['unit_kerja_id']);

            $table->foreign('unit_kerja_id')
                ->references('id')
                ->on('unit_kerjas')
                ->cascadeOnDelete();

        });
    }
};