@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('header_title', 'Daftarkan Anggota Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('members.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>
    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kode Member</label>
                    <input type="text" value="Otomatis (MBR-XXXX)" disabled class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                </div>

                <div>
                    <label for="nama" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required autofocus class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nis_nip" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">NIS / NIP</label>
                        <input type="text" name="nis_nip" id="nis_nip" value="{{ old('nis_nip') }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="telepon" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">No. Telepon / HP *</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email (Opsional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Alamat Lengkap *</label>
                    <textarea name="alamat" id="alamat" rows="3" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors resize-none">{{ old('alamat') }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">Daftarkan</button>
            </div>
        </form>
    </div>
</div>
@endsection