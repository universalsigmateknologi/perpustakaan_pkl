@extends('layouts.app')

@section('title', 'Tambah Rak/Etalase')
@section('header_title', 'Tambah Rak/Etalase Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('admin.etalase.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>

    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        
        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.etalase.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                
                <!-- Kode Rak (Info) -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kode Rak</label>
                    <input type="text" value="Otomatis (RAK-XXXX / ETL-XXXX)" disabled
                           class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                </div>

                <!-- Tipe -->
                <div>
                    <label for="tipe" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Tipe Penyimpanan</label>
                    <select name="tipe" id="tipe" required
                            class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="rak" {{ old('tipe') == 'rak' ? 'selected' : '' }}>Rak (Penyimpanan Utama)</option>
                        <option value="etalase" {{ old('tipe') == 'etalase' ? 'selected' : '' }}>Etalase (Display Depan)</option>
                    </select>
                </div>

                <!-- Nama Rak -->
                <div>
                    <label for="nama_rak" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Rak/Etalase</label>
                    <input type="text" name="nama_rak" id="nama_rak" value="{{ old('nama_rak') }}" required autofocus placeholder="Cth: Rak Ilmu Pengetahuan"
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Lokasi (Opsional)</label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Cth: Lantai 1 / Etalase Depan"
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Kapasitas -->
                <div>
                    <label for="kapasitas" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kapasitas Maksimal (Jumlah Buku)</label>
                    <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', 0) }}" required min="0"
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors resize-none">{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>

</div>
@endsection