@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('header_title', 'Edit Data Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>

    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        
        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                
                <!-- Kode Kategori (Read Only) -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kode Kategori</label>
                    <input type="text" value="{{ $category->kode_kategori }}" disabled
                           class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                </div>

                <!-- Nama Kategori -->
                <div>
                    <label for="nama_kategori" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" required
                           class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors resize-none">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
                    Update Kategori
                </button>
            </div>

        </form>
    </div>

</div>
@endsection