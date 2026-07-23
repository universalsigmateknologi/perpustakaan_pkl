@extends('layouts.app')

@section('title', 'Data Anggota')
@section('header_title', 'Manajemen Anggota Perpustakaan')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Daftar Anggota</h2>
            <p class="text-sm text-gray-500">Kelola data anggota perpustakaan.</p>
        </div>
        <a href="{{ route('members.create') }}" class="inline-flex items-center justify-center bg-black text-white py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
            Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <!-- Form Filter & Search -->
    <div class="bg-white border border-gray-200 p-4 rounded-sm">
        <form action="{{ route('members.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cari Anggota</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / Kode / NIS-NIP / Telepon" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <a href="{{ route('members.index') }}" class="text-xs text-gray-500 hover:text-black py-2 px-4">Reset</a>
                <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-200 transition-colors">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <!-- Tabel Anggota -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode</th>
                        <th class="py-3 px-4 font-medium">Nama</th>
                        <th class="py-3 px-4 font-medium">NIS/NIP</th>
                        <th class="py-3 px-4 font-medium">Telepon</th>
                        <th class="py-3 px-4 font-medium">Status</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($members as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $member->kode_member }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&color=000000&background=EEEEEE&size=32" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $member->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $member->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ $member->nis_nip ?? '-' }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $member->telepon }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs {{ $member->status == 'aktif' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-3">
                            <a href="{{ route('members.edit', $member) }}" class="text-gray-500 hover:text-black">Edit</a>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus anggota ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-6 text-center text-sm text-gray-400">Tidak ada data anggota ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">{{ $members->links() }}</div>
    </div>
</div>
@endsection