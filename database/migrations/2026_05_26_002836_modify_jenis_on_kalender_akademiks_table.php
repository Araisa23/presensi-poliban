<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE kalender_akademiks
            MODIFY jenis ENUM(
                'libur',
                'akademik',
                'ujian',
                'event',
                'nasional'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE kalender_akademiks
            MODIFY jenis ENUM(
                'libur',
                'akademik',
                'ujian',
                'event'
            )
        ");
    }
};