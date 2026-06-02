@extends('layouts.app')

@section('content')
<style>
    /* --- CSS ANIMASI KUSTOM --- */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-entrance {
        opacity: 0;
        animation: fadeSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .table-container { background: white; border-radius: 24px; padding: 30px 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; letter-spacing: 0.5px; border-bottom: 1px solid #f4f7fe; padding-bottom: 20px; }
    table td { padding: 22px 0; border-bottom: 1px solid #f4f7fe; color: #1b254b; font-size: 14px; font-weight: 600;}
    table tr:last-child td { border-bottom: none; }
</style>

<div class="flex justify-between items-center mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Kelola Produk & Jasa</h2>
    <a href="{{ route('produk.create') }}" class="bg-[#5b80ff] hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
        Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 font-medium border border-green-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl mb-6 font-medium border border-blue-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 font-medium border border-red-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
@endif

<div class="table-container animate-entrance" style="animation-delay: 0.3s;">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="uppercase">
                <th class="w-20">ID</th>
                <th>Nama Produk / Jasa</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $p)
            <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                <td class="font-bold text-[#a3aed1]">#{{ $loop->iteration }}</td>
                <td class="font-extrabold text-[#1b254b]">{{ $p->nama_produk }}</td>
                <td class="font-medium text-gray-500">Rp {{ number_format($p->harga_satuan, 0, ',', '.') }}</td>
                <td>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('produk.edit', $p->id_produk ?? $p->id) }}" class="text-[#5b80ff] font-bold hover:text-blue-700 transition text-sm">Edit</a>
                        
                        <form action="{{ route('produk.destroy', $p->id_produk ?? $p->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus produk/jasa ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#fc8181] font-bold hover:text-red-600 transition text-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection