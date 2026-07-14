<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensis', function (Blueprint $table) {   // <-- ubah jadi 'presensis'
            $table->decimal('gps_accuracy', 8, 2)->nullable()->after('lng');
            $table->boolean('is_suspicious')->default(false)->after('gps_accuracy');
            $table->string('suspicious_reason')->nullable()->after('is_suspicious');
        });
    }

    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {   // <-- ubah jadi 'presensis'
            $table->dropColumn(['gps_accuracy', 'is_suspicious', 'suspicious_reason']);
        });
    }
};