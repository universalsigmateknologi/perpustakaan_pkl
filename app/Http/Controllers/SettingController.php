<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Menampilkan form pengaturan
    public function index()
    {
        // Ambil data pertama (id=1). Jika belum ada, buat instance baru default
        $setting = Setting::firstOrNew(['id' => 1]);
        
        return view('admin.settings.index', compact('setting'));
    }

    // Menyimpan / Update pengaturan
    public function update(Request $request)
    {
        $request->validate([
            'nama_perpustakaan' => 'required|string',
            'denda_per_hari' => 'required|integer|min:0',
            'maksimal_hari_pinjam' => 'required|integer|min:1',
            'batas_jumlah_buku' => 'required|integer|min:1',
        ]);

        // UpdateOrCreate akan selalu mengupdate data dengan ID 1, tidak akan membuat ID 2
        Setting::updateOrCreate(
            ['id' => 1],
            $request->all()
        );

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
