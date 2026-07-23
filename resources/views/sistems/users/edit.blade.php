@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('header_title', 'Edit Data Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>

    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        
        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Foto Preview -->
                <div class="md:col-span-2 flex items-center space-x-4 pb-4 border-b border-gray-100 mb-4">
                    <img src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=000000&background=EEEEEE' }}" 
                         alt="Avatar" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">Klik di bawah untuk mengganti foto</p>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Password Baru (Opsional) -->
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah"
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru"
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Role / Hak Akses</label>
                    <select name="role" id="role" required
                            class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Foto -->
                <div>
                    <label for="foto" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ganti Foto Profil</label>
                    <input type="file" name="foto" id="foto" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
                    Update Pengguna
                </button>
            </div>

        </form>
    </div>

</div>
@endsection