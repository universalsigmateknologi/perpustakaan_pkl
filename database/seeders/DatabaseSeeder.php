<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => "zinedine zidanir rizki",
            'username' => "petugas", // Tambahkan ini
            'email' => "peacemannauval@gmail.com",
            'email_verified_at' => now(),
            'password' => Hash::make('petugas123'), // password
            'role' => 'petugas',
            'remember_token' => Str::random(10),
        ]);

        // Panggil SettingSeeder di sini
        // $this->call([
        //     SettingSeeder::class,
        // ]);
    }
}
