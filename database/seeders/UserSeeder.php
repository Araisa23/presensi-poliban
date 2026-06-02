<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $pimpinanRole = Role::where('name', 'pimpinan')->first();

        User::create([
            'name' => 'Administrator',
            'nip' => '111111111',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Pimpinan',
            'nip' => '222222222',
            'email' => 'pimpinan@admin.com',
            'password' => Hash::make('pimpinan123'),
            'role_id' => $pimpinanRole->id,
        ]);
    }
}