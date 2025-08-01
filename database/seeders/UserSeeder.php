<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('PasswordS'),
            'role' => 'admin',
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'username' => 'penjualan',
            'password' => Hash::make('PasswordS'),
            'role' => 'penjualan',
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'username' => 'pembelian',
            'password' => Hash::make('PasswordS'),
            'role' => 'pembelian',
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'username' => 'persediaan',
            'password' => Hash::make('PasswordS'),
            'role' => 'persediaan',
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'username' => 'finance',
            'password' => Hash::make('PasswordS'),
            'role' => 'finance',
            'remember_token' => Str::random(60),
        ]);
    }
}
