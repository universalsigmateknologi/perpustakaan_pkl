@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Dashboard</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-700">Selamat Datang, {{ auth()->user()->name }}! 🎉</h2>
        <p class="text-gray-500 mt-2">Anda login sebagai <span class="font-bold text-indigo-600 uppercase">{{ auth()->user()->role }}</span></p>
    </div>
</div>
@endsection