<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Menampilkan halaman pengaturan
    public function index()
    {
        // Ambil semua settings dan format menjadi array [key => value]
        $settings = Setting::pluck('value', 'key')->toArray();
        
        return view('settings.index', compact('settings'));
    }

    // Menyimpan pengaturan
    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_perpustakaan'     => 'required|string|max:255',
            'email_perpustakaan'    => 'required|email|max:255',
            'telepon_perpustakaan'  => 'required|string|max:20',
            'alamat_perpustakaan'   => 'required|string',
            'denda_per_hari'        => 'required|numeric|min:0',
            'maksimal_hari_pinjam'  => 'required|integer|min:1',
            'maksimal_jumlah_buku'  => 'required|integer|min:1',
            'logo_perpustakaan'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        // Daftar key yang akan diupdate (kecuali logo)
        $keys = [
            'nama_perpustakaan',
            'email_perpustakaan',
            'telepon_perpustakaan',
            'alamat_perpustakaan',
            'denda_per_hari',
            'maksimal_hari_pinjam',
            'maksimal_jumlah_buku'
        ];

        // Looping dan simpan/update data text/number
        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $validated[$key]]
            );
        }

        // Proses upload logo jika ada file baru
        if ($request->hasFile('logo_perpustakaan')) {
            // Hapus logo lama jika ada
            $oldLogo = Setting::where('key', 'logo_perpustakaan')->first();
            if ($oldLogo && $oldLogo->value) {
                Storage::disk('public')->delete($oldLogo->value);
            }

            // Simpan logo baru di folder storage/app/public/logos
            $path = $request->file('logo_perpustakaan')->store('logos', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'logo_perpustakaan'],
                ['value' => $path]
            );
        }

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}