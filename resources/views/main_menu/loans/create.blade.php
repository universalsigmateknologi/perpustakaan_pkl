@extends('layouts.app')

@section('title', 'Buat Peminjaman')
@section('header_title', 'Transaksi Peminjaman Baru')

@section('content')
<div class="max-w-5xl mx-auto" x-data="loanForm()">
    
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('loans.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Kembali ke Daftar</a>
    </div>

    @if(session('error'))
        <div class="mb-6 p-3 bg-red-50 border-l-2 border-red-500 text-red-600 text-sm" x-data="{ show: true }" x-show="show" x-transition>
            {{ session('error') }}
            <button @click="show = false" class="float-right text-red-400 hover:text-red-600">&times;</button>
        </div>
    @endif

    <!-- STEP 1: Pilih Anggota -->
    @if(!$member)
    <div class="bg-white border border-gray-200 p-6 rounded-sm">
        <h3 class="text-sm font-medium text-gray-900 mb-6 pb-3 border-b border-gray-100">1. Cari Data Anggota</h3>
        <form action="{{ route('loans.create') }}" method="GET">
            <div class="flex gap-4">
                <input type="text" name="member_search" required autofocus placeholder="Masukkan Kode Member, NIS/NIP, atau Nama..." class="flex-1 px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                <button type="submit" class="bg-black text-white py-2 px-6 text-xs uppercase tracking-widest font-medium hover:bg-gray-800">Cari</button>
            </div>
        </form>

        @if($memberResults->isNotEmpty())
        <div class="mt-6 divide-y divide-gray-100">
            @foreach($memberResults as $m)
            <div class="py-3 flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">{{ $m->nama }} <span class="text-xs text-gray-400">({{ $m->kode_member }})</span></p>
                    <p class="text-xs text-gray-500">{{ $m->nis_nip ?? 'Tanpa NIS/NIP' }} - {{ $m->telepon }}</p>
                </div>
                <a href="{{ route('loans.create', ['member_id' => $m->id]) }}" class="text-xs text-black border-b border-black hover:opacity-70">Pilih Anggota</a>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @else
    <!-- STEP 2: Pilih Buku & Keranjang -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Pencarian Buku -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Info Anggota -->
            <div class="bg-white border border-gray-200 p-5 rounded-sm flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Anggota Peminjam</p>
                    <h3 class="text-lg font-medium text-gray-900 mt-1">{{ $member->nama }}</h3>
                    <p class="text-xs text-gray-500">{{ $member->kode_member }} - {{ $member->telepon }}</p>
                </div>
                <a href="{{ route('loans.create') }}" class="text-xs text-gray-500 hover:text-black border-b border-gray-300 hover:border-black">Ganti</a>
            </div>

            <!-- Form Cari Buku -->
            <div class="bg-white border border-gray-200 p-6 rounded-sm">
                <h3 class="text-sm font-medium text-gray-900 mb-4">2. Cari Buku</h3>
                <form action="{{ route('loans.create') }}" method="GET">
                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                    <div class="flex gap-4">
                        <input type="text" name="book_search" required autofocus placeholder="Kode Buku, ISBN, atau Judul..." class="flex-1 px-0 py-2 bg-transparent border-0 border-b border-gray-300 text-gray-900 focus:border-black transition-colors">
                        <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-6 text-xs uppercase tracking-widest font-medium hover:bg-gray-200">Cari</button>
                    </div>
                </form>

                @if($books->isNotEmpty())
                <div class="mt-6 space-y-3">
                    @foreach($books as $book)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-sm hover:bg-gray-50">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://ui-avatars.com/api/?name=B&color=000000&background=EEEEEE&size=32' }}" class="w-8 h-10 object-cover">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $book->judul }}</p>
                                <p class="text-xs text-gray-500">{{ $book->kode_buku }} (Stok: {{ $book->tersedia }})</p>
                            </div>
                        </div>
                        <button type="button" @click="addBook({{ $book->id }}, '{{ addslashes($book->judul) }}', '{{ $book->kode_buku }}')" class="text-xs bg-black text-white px-3 py-1.5 hover:bg-gray-800">Tambah</button>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Keranjang Peminjaman -->
        <div class="lg:col-span-1">
            <form action="{{ route('loans.store') }}" method="POST" class="bg-white border border-gray-200 p-6 rounded-sm sticky top-20">
                @csrf
                <input type="hidden" name="member_id" value="{{ $member->id }}">
                
                <h3 class="text-sm font-medium text-gray-900 mb-4 pb-3 border-b border-gray-100">Keranjang Pinjaman</h3>
                
                <div class="space-y-3 mb-4 min-h-[100px]">
                    <!-- Empty State -->
                    <template x-if="cart.length === 0">
                        <p class="text-xs text-gray-400 text-center py-8">Belum ada buku dipilih.</p>
                    </template>

                    <!-- Cart Items -->
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex-1 pr-2">
                                <p class="font-medium text-gray-900" x-text="item.judul"></p>
                                <p class="text-xs text-gray-400" x-text="item.kode"></p>
                            </div>
                            <button type="button" @click="removeBook(index)" class="text-red-500 hover:text-red-700 text-xs">&times;</button>
                        </div>
                    </template>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-4">
                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                        <span>Maksimal Buku:</span>
                        <span class="font-medium text-gray-900">{{ $maxBooks }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Dipilih:</span>
                        <span class="font-medium text-gray-900" x-text="cart.length + ' Buku'"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="catatan" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="2" class="w-full px-0 py-1 bg-transparent border-0 border-b border-gray-300 text-sm focus:border-black resize-none"></textarea>
                </div>

                <!-- Hidden inputs untuk books[] -->
                <template x-for="item in cart" :key="item.id">
                    <input type="hidden" name="books[]" :value="item.id">
                </template>

                <button type="submit" class="w-full bg-black text-white py-3 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" :disabled="cart.length === 0">
                    Simpan Transaksi
                </button>
            </form>
        </div>
    </div>
    @endif

</div>

<script>
function loanForm() {
    return {
        cart: [],
        addBook(id, judul, kode) {
            // Cek apakah sudah ada di cart
            if (this.cart.some(item => item.id === id)) {
                alert('Buku ini sudah ada di keranjang!');
                return;
            }
            this.cart.push({ id, judul, kode });
        },
        removeBook(index) {
            this.cart.splice(index, 1);
        }
    }
}
</script>
@endsection