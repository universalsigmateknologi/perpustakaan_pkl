@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('header_title', 'Tambah Buku Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>
    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kode Buku</label>
                    <input type="text" value="Otomatis (BK-XXXXX)" disabled class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                </div>

                <div class="md:col-span-2">
                    <label for="judul" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Judul Buku *</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required autofocus class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="isbn" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">ISBN (Opsional)</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="tahun_terbit" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Tahun Terbit *</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" required min="1900" max="{{ date('Y') }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kategori *</label>
                    <select name="category_id" id="category_id" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="author_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Penulis *</label>
                    <select name="author_id" id="author_id" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="">-- Pilih Penulis --</option>
                        @foreach($authors as $aut)
                            <option value="{{ $aut->id }}" {{ old('author_id') == $aut->id ? 'selected' : '' }}>{{ $aut->nama_penulis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="publisher_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Penerbit *</label>
                    <select name="publisher_id" id="publisher_id" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="">-- Pilih Penerbit --</option>
                        @foreach($publishers as $pub)
                            <option value="{{ $pub->id }}" {{ old('publisher_id') == $pub->id ? 'selected' : '' }}>{{ $pub->nama_penerbit }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="shelf_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Rak / Etalase</label>
                    <select name="shelf_id" id="shelf_id" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <option value="">-- Tanpa Rak --</option>
                        @foreach($shelves as $sh)
                            <option value="{{ $sh->id }}" {{ old('shelf_id') == $sh->id ? 'selected' : '' }}>[{{ $sh->kode_rak }}] {{ $sh->nama_rak }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="jumlah" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Jumlah Stok (Eksemplar) *</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', 1) }}" required min="0" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>

                <div>
                    <label for="cover" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Cover Buku</label>
                    <input type="file" name="cover" id="cover" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors resize-none">{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection