@extends('layouts.auth')

@section('title', 'Login Sistem Perpustakaan')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-2xl w-full">
    
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">PERPUSAPP</h1>
        <p class="text-gray-500 mt-2">Sistem Manajemen Perpustakaan Digital</p>
    </div>

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        {{-- Input Login (Username / Email) --}}
        <div class="mb-5">
            <label for="login" class="block text-sm font-medium text-gray-700 mb-2">Username atau Email</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                   placeholder="Masukkan Username atau Email" required autofocus>
        </div>

        {{-- Input Password --}}
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" name="password" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                   placeholder="Masukkan password" required>
        </div>

        <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
            LOGIN
        </button>
    </form>
</div>
@endsection