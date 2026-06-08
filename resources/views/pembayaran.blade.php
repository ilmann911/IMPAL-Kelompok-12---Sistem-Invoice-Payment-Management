@extends('layouts.app')

@section('content')
<style>

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-entrance {
        opacity: 0;
        animation: fadeSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        padding: 30px 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; letter-spacing: 0.5px; border-bottom: 1px solid #f4f7fe; padding-bottom: 20px; }
    table td { padding: 22px 0; border-bottom: 1px solid #f4f7fe; color: #1b254b; font-size: 14px; font-weight: 600;}
    table tr:last-child td { border-bottom: none; }

    .search-input {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 16px;
        width: 260px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        color: #1b254b;
    }
    .search-input:focus {
        outline: none;
        border-color: #5b80ff;
        box-shadow: 0 0 0 3px rgba(91, 128, 255, 0.1);
    }
    .btn-filter {
        background-color: #5b80ff;
        color: white;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(91,128,255,0.2);
    }
    .btn-filter:hover { background-color: #4869dd; }

    .badge { padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; text-align: center; }
    .badge-paid { background-color: #def7ec; color: #057a55; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }

    .btn-bukti {
        background-color: #eef2ff;
        color: #5b80ff;
        font-weight: 800;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-bukti:hover {
        background-color: #e0e7ff;
        color: #4338ca;
    }
</style>

<div class="flex justify-between items-center mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Riwayat Pembayaran</h2>
    
    <div class="flex items-center gap-3">
        <input type="text" placeholder="Cari Pembayaran..." class="search-input">
        <button class="btn-filter">Filter</button>
    </div>
</div>

<div class="table-container animate-entrance" style="animation-delay: 0.2s;">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="uppercase">
                    <th class="px-2">No. Invoice</th>
                    <th class="px-2">Customer</th>
                    <th class="px-2">Tanggal Bayar</th>
                    <th class="px-2">Total</th>
                    <th class="px-2 text-center">Status</th>
                    <th class="px-2 text-center">Aksi & Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                    <td class="font-extrabold text-[#5b80ff] px-2">{{ $pay->invoice->no_invoice ?? 'Tidak Diketahui' }}</td>
                    
                    <td class="font-medium text-gray-500 px-2">{{ $pay->invoice->klien->nama_klien ?? 'Tidak Diketahui' }}</td> 
                    
                    <td class="font-medium text-gray-500 px-2">{{ $pay->tanggal_bayar }}</td>
                    
                    <td class="font-extrabold text-[#1b254b] px-2">Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}</td>
                    
                    <td class="px-2 text-center">
                        <span class="badge 
                            {{ $pay->status_verifikasi == 'Paid' ? 'badge-paid' : '' }}
                            {{ $pay->status_verifikasi == 'Pending' ? 'badge-pending' : '' }}">
                            {{ $pay->status_verifikasi }}
                        </span>
                    </td>
                    <td class="px-2 text-center">
                        <a href="#" class="btn-bukti">
                            <i class="fas fa-eye text-sm"></i> Lihat Bukti
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400 font-medium italic">
                        Belum ada data pembayaran yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p class="text-[12.5px] text-gray-400 mt-6 italic font-medium">
        * Data ini disinkronkan otomatis saat pelanggan mengunggah bukti pembayaran. Admin memverifikasi bukti yang berstatus "Pending".
    </p>
</div>
@endsection