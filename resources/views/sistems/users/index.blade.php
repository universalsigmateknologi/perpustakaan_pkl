@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header_title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    
    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Daftar Pengguna Sistem</h2>
            <p class="text-sm text-gray-500">Kelola akun admin dan petugas perpustakaan.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center bg-black text-white py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
            Tambah Pengguna
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-50 border-l-2 border-red-500 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Data User -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Pengguna</th>
                        <th class="py-3 px-4 font-medium">Username</th>
                        <th class="py-3 px-4 font-medium">Role</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=000000&background=EEEEEE' }}" 
                                     alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600 font-mono text-xs">{{ $user->username }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs {{ $user->role == 'admin' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-500 hover:text-black">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-sm text-gray-400">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection