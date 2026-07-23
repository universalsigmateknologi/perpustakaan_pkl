<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIPERPUS</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AlpineJS untuk interaktivitas sidebar/dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        * { -webkit-font-smoothing: antialiased; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen z-40 transition-transform duration-300 lg:translate-x-0" :class="{ '-translate-x-full': !sidebarOpen }" x-data="{ sidebarOpen: false }">
            <div class="h-16 flex items-center justify-center border-b border-gray-200">
                <h1 class="text-xl font-light tracking-widest text-gray-900">SIPERPUS</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
                <!-- Menu Dashboard -->
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('petugas.dashboard') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-sm">
                   <span>Dashboard</span>
                </a>

                <div class="pt-4 pb-2 px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Menu Utama</div>

                <!-- Menu Operasional (Admin & Petugas) -->
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Anggota</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Peminjaman</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Pengembalian</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Denda</span>
                </a>

                @if(auth()->user()->role === 'admin')
                <!-- Menu Khusus Admin -->
                <div class="pt-4 pb-2 px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Master Data</div>
                
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Data Buku</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Kategori</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Rak & Etalase</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Penulis & Penerbit</span>
                </a>

                <div class="pt-4 pb-2 px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Sistem</div>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Manajemen User</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                    <span>Pengaturan</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-sm transition-colors">
                    <span>Laporan</span>
                </a>
                @endif
            </nav>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div x-show="sidebarOpen" class="fixed inset-0 bg-black opacity-50 z-30 lg:hidden" @click="sidebarOpen = false" x-data="{ sidebarOpen: false }"></div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64" x-data="{ sidebarOpen: false }">
            
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-20">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <div class="flex-1 lg:flex-none">
                    <h2 class="text-sm font-medium text-gray-600 hidden lg:block">@yield('header_title', 'Halaman Ini')</h2>
                </div>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-sm focus:outline-none">
                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=000000&background=EEEEEE' }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                        <span class="hidden md:block text-gray-700">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-sm shadow-sm py-1" style="display: none;">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Keluar</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>

    </div>

    @yield('scripts')
</body>
</html>