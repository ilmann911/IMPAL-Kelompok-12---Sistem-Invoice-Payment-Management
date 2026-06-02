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

    /* Styling Wadah Tabel (Konsisten dengan Dashboard, Klien, & Produk) */
    .table-container {
        background: white;
        border-radius: 24px;
        padding: 30px 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; letter-spacing: 0.5px; border-bottom: 1px solid #f4f7fe; padding-bottom: 20px; }
    table td { padding: 22px 0; border-bottom: 1px solid #f4f7fe; color: #1b254b; font-size: 14px; font-weight: 600;}
    table tr:last-child td { border-bottom: none; }

    /* Styling Kotak Pencarian Input */
    .search-input {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 20px;
        width: 100%;
        transition: all 0.3s;
        font-size: 14px;
        color: #1b254b;
    }
    .search-input:focus {
        outline: none;
        border-color: #5b80ff;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(91, 128, 255, 0.1);
    }

    /* Badge Status Pil Bulat */
    .badge { padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; text-align: center; }
    .badge-paid { background-color: #def7ec; color: #057a55; }
    .badge-draft { background-color: #f3f4f6; color: #4b5563; }
    .badge-sent { background-color: #e1effe; color: #1e429f; }
    .badge-overdue { background-color: #fde8e8; color: #c81e1e; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }

    /* Tombol Aksi */
    .btn-action { font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 8px; transition: all 0.2s; display: inline-block; text-align: center; }
    .btn-blue { background-color: #3b82f6; color: white; }
    .btn-blue:hover { background-color: #2563eb; }
    .btn-green { background-color: #22c55e; color: white; }
    .btn-green:hover { background-color: #16a34a; }
</style>

<div class="flex justify-between items-center mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Kelola Invoice</h2>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('invoice.trigger-reminder') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md shadow-yellow-500/30">
            <i class="fas fa-sync-alt mr-1"></i> Cek Jatuh Tempo
        </a>

        <a href="{{ route('invoice.create') }}" class="bg-[#5b80ff] hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
            + Tambah Invoice
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 font-medium border border-green-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 font-medium border border-red-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
@endif

<div class="table-container animate-entrance" style="animation-delay: 0.3s;">
    
    <form action="{{ route('invoice.index') }}" method="GET" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Invoice, Klien, atau Status lalu tekan Enter..." class="search-input w-full">
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="uppercase">
                    <th class="px-2">No. Invoice</th>
                    <th class="px-2">Customer</th>
                    <th class="px-2">Date</th>
                    <th class="px-2">Total</th>
                    <th class="px-2">Status</th>
                    <th class="px-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($invoices as $inv)
                <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                    <td class="font-extrabold text-[#1b254b] px-2">{{ $inv->no_invoice }}</td>
                    <td class="font-medium text-gray-500 px-2">{{ $inv->klien->nama_klien ?? 'Tidak Diketahui' }}</td> 
                    <td class="font-medium text-gray-500 px-2">{{ $inv->tanggal_buat }}</td>
                    <td class="font-extrabold text-[#1b254b] px-2">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                    <td class="px-2">
                        <span class="badge 
                            {{ $inv->status == 'Paid' ? 'badge-paid' : '' }}
                            {{ $inv->status == 'Pending' ? 'badge-pending' : '' }}
                            {{ $inv->status == 'Sent' ? 'badge-sent' : '' }}
                            {{ $inv->status == 'Draft' ? 'badge-draft' : '' }}
                            {{ $inv->status == 'Overdue' ? 'badge-overdue' : '' }}">
                            {{ $inv->status }}
                        </span>
                    </td>
                    <td class="px-2">
                        <div class="flex items-center gap-2">
                            @if($inv->status == 'Draft')
                                <form action="{{ route('invoice.updateStatus', $inv->id_invoice) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <input type="hidden" name="status" value="Sent">
                                    <button type="submit" class="btn-action btn-blue">Kirim</button>
                                </form>
                            @else
                                <span class="text-gray-400 font-medium pl-4">-</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500 font-medium">
                        <i class="fas fa-search text-2xl mb-2 text-gray-300 block"></i>
                        Data invoice tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection