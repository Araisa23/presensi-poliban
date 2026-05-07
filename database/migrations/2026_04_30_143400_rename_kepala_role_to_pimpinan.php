<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Jika sebelumnya sempat memakai role "kepala", samakan menjadi "pimpinan"
        DB::table('roles')->where('name', 'kepala')->update(['name' => 'pimpinan']);
    }

    public function down(): void
    {
        DB::table('roles')->where('name', 'pimpinan')->update(['name' => 'kepala']);
    }
};

