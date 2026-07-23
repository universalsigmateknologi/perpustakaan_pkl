@extends('layouts.app')

@section('title', 'Edit Anggota')
@section('header_title', 'Edit Data Anggota')

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

        <form action="{{ route('members.update', $member) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-6">
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kode Member</label>
                        <input type="text" value="{{ $member->kode_member }}" disabled class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Tgl. Daftar</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($member->tanggal_daftar)->format('d M Y') }}" disabled class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                    </div>
                </div>

                <div>
                    <label for="nama" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $member->nama) }}" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nis_nip" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">NIS / NIP</label>
                        <input type="text" name="nis_nip" id="nis_nip" value="{{ old('nis_nip', $member->nis_nip) }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $member->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="telepon" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">No. Telepon / HP *</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $member->telepon) }}" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email (Opsional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Alamat Lengkap *</label>
                    <textarea name="alamat" id="alamat" rows="3" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors resize-none">{{ old('alamat', $member->alamat) }}</textarea>
                </div>

                <div>
                    <label for="status" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Status Keanggotaan *</label>
                    <select name="status" id="status" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="aktif" {{ old('status', $member->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $member->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection