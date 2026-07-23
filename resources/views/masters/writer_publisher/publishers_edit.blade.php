@extends('layouts.app')

@section('title', 'Edit Penerbit')
@section('header_title', 'Edit Data Penerbit')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.publishers.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>
    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif
        <form action="{{ route('admin.publishers.update', $publisher) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Kode Penerbit</label>
                    <input type="text" value="{{ $publisher->kode_penerbit }}" disabled class="w-full px-0 py-2 bg-gray-50 border-0 border-b border-gray-200 text-gray-400 cursor-not-allowed">
                </div>
                <div>
                    <label for="nama_penerbit" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Penerbit</label>
                    <input type="text" name="nama_penerbit" id="nama_penerbit" value="{{ old('nama_penerbit', $publisher->nama_penerbit) }}" required class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telepon" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Telepon</label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $publisher->telepon) }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $publisher->email) }}" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                    </div>
                </div>
                <div>
                    <label for="alamat" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors resize-none">{{ old('alamat', $publisher->alamat) }}</textarea>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-black text-white py-3 px-8 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection