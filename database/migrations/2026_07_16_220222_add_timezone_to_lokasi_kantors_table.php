<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lokasi_kantors', function (Blueprint $table) {
            $table->string('timezone')->default('Asia/Makassar')->after('radius');
        });
    }

    public function down(): void
    {
        Schema::table('lokasi_kantors', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
};