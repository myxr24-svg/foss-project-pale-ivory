<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'pale-ivory@admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'pale-ivory@superadmin',
            'password' => Hash::make('superadmin'),
            'role' => 'superadmin',
        ]);
    }
}
