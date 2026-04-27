@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center">
    <h2 class="text-2xl font-bold text-slate-800">Tambah Data Produk / Jasa</h2>
</div>

<div class="bg-white rounded shadow p-6 max-w-2xl">
    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-slate-700 font-bold mb-2">Nama Produk / Jasa</label>
            <input type="text" name="nama_produk" class="w-full border p-3 rounded focus:outline-blue-500 bg-slate-50" placeholder="Contoh: Jasa Pembuatan Website" required>
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 font-bold mb-2">Harga (Rp)</label>
            <input type="number" name="harga_satuan" class="w-full border p-3 rounded focus:outline-blue-500 bg-slate-50" placeholder="Contoh: 1500000" min="0" required>
        </div>

        <div class="flex space-x-3">
            <a href="{{ route('produk.index') }}" class="bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded shadow">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection