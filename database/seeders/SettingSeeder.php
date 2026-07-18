<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan updateOrInsert agar jika dijalankan ulang, data tidak bertambah menjadi 2
        DB::table('settings')->updateOrInsert(
            ['id' => 1], // Kunci pada ID 1
            [
                'nama_perpustakaan' => 'Perpustakaan SMA Negeria 1',
                'denda_per_hari' => 1000,
                'maksimal_hari_pinjam' => 7,
                'batas_jumlah_buku' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
