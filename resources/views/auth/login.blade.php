@extends('layouts.auth')

@section('title', 'Login Petugas')

@section('content')
    
    <!-- Header Section -->
    <div class="text-center mb-10">
        <h1 class="text-2xl font-light tracking-tight text-gray-900">PERPUSTAKAAN</h1>
        <div class="mt-2 mx-auto w-12 h-px bg-gray-300"></div>
        <p class="mt-4 text-xs text-gray-500 uppercase tracking-widest">Silakan Masuk</p>
    </div>

    <!-- Flash Message Error (Jika ada) -->
    @if (session('error'))
        <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-xs">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Login -->
    <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Input Username / Email -->
        <div>
            <label for="login" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Username atau Email</label>
            <input 
                type="text" 
                id="login" 
                name="login" 
                value="{{ old('login') }}" 
                required 
                autofocus
                class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200"
                placeholder="Masukkan username/email"
            >
            @error('login')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Password -->
        <div>
            <label for="password" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
                class="w-full px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 placeholder-gray-400 focus:border-black transition-colors duration-200"
                placeholder="Masukkan password"
            >
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password (Opsional) -->
        <div class="flex items-center justify-between pt-2">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="remember" class="w-3 h-3 border-gray-300 text-black focus:ring-black rounded-sm">
                <span class="ml-2 text-xs text-gray-500">Ingat saya</span>
            </label>
            <!-- Tambahkan route lupa password jika ada -->
            <!-- <a href="#" class="text-xs text-gray-500 hover:text-black transition-colors">Lupa password?</a> -->
        </div>

        <!-- Submit Button -->
        <div class="pt-6">
            <button 
                type="submit" 
                class="w-full bg-black text-white py-3 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black"
            >
                Masuk ke Sistem
            </button>
        </div>

    </form>

@endsection