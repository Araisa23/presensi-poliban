<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('jadwal_kerjas', function (Blueprint $table) {
        $table->time('batas_awal_masuk')->nullable()->after('jam_masuk');
        $table->time('batas_akhir_masuk')->nullable()->after('batas_awal_masuk');
        $table->time('batas_awal_pulang')->nullable()->after('jam_pulang');
        $table->time('batas_akhir_pulang')->nullable()->after('batas_awal_pulang');
    });
}

public function down()
{
    Schema::table('jadwal_kerjas', function (Blueprint $table) {
        $table->dropColumn(['batas_awal_masuk', 'batas_akhir_masuk', 'batas_awal_pulang', 'batas_akhir_pulang']);
    });
}
};
