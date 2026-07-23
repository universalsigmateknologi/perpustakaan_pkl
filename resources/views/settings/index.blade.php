@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('header_title', 'Pengaturan Sistem')

@section('content')

<div class="max-w-4xl mx-auto">
    
    <!-- Flash Message -->
    @if(session('success'))
        <div class="mb-6 p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Kolom Kiri: Identitas Perpustakaan -->
            <div class="space-y-6">
                <div class="bg-white border border-gray-200 p-6 rounded-sm">
                    <h3 class="text-sm font-medium text-gray-900 mb-6 pb-3 border-b border-gray-100">Informasi Perpustakaan</h3>
                    
                    <div class="space-y-5">
                        <!-- Logo -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Logo Perpustakaan</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ isset($settings['logo_perpustakaan']) && $settings['logo_perpustakaan'] ? asset('storage/' . $settings['logo_perpustakaan']) : 'https://ui-avatars.com/api/?name=LOGO&color=000000&background=EEEEEE' }}" 
                                     alt="Logo" class="w-20 h-20 object-cover border border-gray-200 rounded-sm bg-gray-50">
                                <div class="flex-1">
                                    <input type="file" name="logo_perpustakaan" id="logo_perpustakaan" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                                    <p class="mt-1 text-xs text-gray-400">PNG, JPG (MAX. 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nama -->
                        <div>
                            <label for="nama_perpustakaan" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Perpustakaan</label>
                            <input type="text" name="nama_perpustakaan" id="nama_perpustakaan" value="{{ $settings['nama_perpustakaan'] ?? '' }}" required
                                   class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email_perpustakaan" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email</label>
                            <input type="email" name="email_perpustakaan" id="email_perpustakaan" value="{{ $settings['email_perpustakaan'] ?? '' }}" required
                                   class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200">
                        </div>

                        <!-- Telepon -->
                        <div>
                            <label for="telepon_perpustakaan" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Telepon</label>
                            <input type="text" name="telepon_perpustakaan" id="telepon_perpustakaan" value="{{ $settings['telepon_perpustakaan'] ?? '' }}" required
                                   class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat_perpustakaan" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Alamat</label>
                            <textarea name="alamat_perpustakaan" id="alamat_perpustakaan" rows="3" required
                                      class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200 resize-none">{{ $settings['alamat_perpustakaan'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Aturan Sistem -->
            <div class="space-y-6">
                <div class="bg-white border border-gray-200 p-6 rounded-sm">
                    <h3 class="text-sm font-medium text-gray-900 mb-6 pb-3 border-b border-gray-100">Aturan Sistem</h3>
                    
                    <div class="space-y-5">
                        <!-- Denda per Hari -->
                        <div>
                            <label for="denda_per_hari" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Denda per Hari</label>
                            <div class="flex items-center">
                                <span class="text-gray-500 mr-2 text-sm">Rp</span>
                                <input type="number" name="denda_per_hari" id="denda_per_hari" value="{{ $settings['denda_per_hari'] ?? 1000 }}" required min="0"
                                       class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200">
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Dikenakan untuk setiap hari keterlambatan.</p>
                        </div>

                        <!-- Maksimal Hari Pinjam -->
                        <div>
                            <label for="maksimal_hari_pinjam" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Maksimal Hari Peminjaman</label>
                            <div class="flex items-center">
                                <input type="number" name="maksimal_hari_pinjam" id="maksimal_hari_pinjam" value="{{ $settings['maksimal_hari_pinjam'] ?? 7 }}" required min="1"
                                       class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200">
                                <span class="text-gray-500 ml-2 text-sm">Hari</span>
                            </div>
                        </div>

                        <!-- Maksimal Jumlah Buku -->
                        <div>
                            <label for="maksimal_jumlah_buku" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Maksimal Jumlah Buku</label>
                            <div class="flex items-center">
                                <input type="number" name="maksimal_jumlah_buku" id="maksimal_jumlah_buku" value="{{ $settings['maksimal_jumlah_buku'] ?? 3 }}" required min="1"
                                       class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200">
                                <span class="text-gray-500 ml-2 text-sm">Buku</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Batas jumlah buku yang bisa dipinjam dalam 1 transaksi.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tombol Submit -->
        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black">
                Simpan Pengaturan
            </button>
        </div>

    </form>

</div>

@endsection