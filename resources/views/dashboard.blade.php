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

    /* Styling Kartu Metrik Persis Gambar */
    .card-metric {
        border-radius: 20px;
        padding: 24px 30px;
        color: white;
        position: relative;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    /* Lingkaran Dekorasi Transparan di Kanan */
    .card-metric::after {
        content: '';
        position: absolute;
        right: -30px;
        top: 50%;
        transform: translateY(-50%);
        width: 130px;
        height: 130px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
    }

    /* Warna Kartu Solid Soft */
    .bg-card-blue { background-color: #5b80ff; }
    .bg-card-green { background-color: #48bb78; }
    .bg-card-gray { background-color: #a0aec0; }
    .bg-card-red { background-color: #fc8181; }
    
    .metric-title { font-size: 14px; font-weight: 500; margin-bottom: 6px;}
    .metric-value { font-size: 38px; font-weight: 800; line-height: 1; }
    
    /* Styling Wadah Tabel */
    .table-container {
        background: white;
        border-radius: 24px;
        padding: 30px 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-top: 30px;
    }
    
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; letter-spacing: 0.5px; border-bottom: 1px solid #f4f7fe; padding-bottom: 20px; }
    table td { padding: 22px 0; border-bottom: 1px solid #f4f7fe; color: #1b254b; font-size: 14px; font-weight: 600;}
    table tr:last-child td { border-bottom: none; }
    
    /* Warna Status Pil */
    .badge { padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; }
    .badge-paid { background-color: #def7ec; color: #057a55; }
    .badge-draft { background-color: #f3f4f6; color: #4b5563; }
    .badge-sent { background-color: #e1effe; color: #1e429f; }
    .badge-overdue { background-color: #fde8e8; color: #c81e1e; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }
</style>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="card-metric bg-card-blue animate-entrance" style="animation-delay: 0.1s;">
        <div class="metric-title">Total Invoice</div>
        <div class="metric-value">{{ $totalInvoice }}</div>
    </div>
    <div class="card-metric bg-card-green animate-entrance" style="animation-delay: 0.2s;">
        <div class="metric-title">Paid</div>
        <div class="metric-value">{{ $paid }}</div>
    </div>
    <div class="card-metric bg-card-gray animate-entrance" style="animation-delay: 0.3s;">
        <div class="metric-title">Unpaid</div>
        <div class="metric-value">{{ $unpaid }}</div>
    </div>
    <div class="card-metric bg-card-red animate-entrance" style="animation-delay: 0.4s;">
        <div class="metric-title">Overdue</div>
        <div class="metric-value">{{ $overdue }}</div>
    </div>
</div>

<div class="table-container animate-entrance" style="animation-delay: 0.5s;">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="uppercase">
                    <th>No. Invoice</th>
                    <th>Customer</th>
                    <th>Tgl Terbit</th>
                    <th>Jatuh Tempo</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $inv)
                <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                    <td class="font-extrabold text-[#1b254b]">{{ $inv->no_invoice }}</td>
                    <td class="font-medium text-gray-500">{{ $inv->klien->nama_klien ?? 'Tidak Diketahui' }}</td> 
                    <td class="font-medium text-gray-500">{{ \Carbon\Carbon::parse($inv->tanggal_buat)->format('Y-m-d') }}</td>
                    <td class="font-bold 
                        {{ $inv->status == 'Paid' ? 'text-[#057a55]' : '' }}
                        {{ $inv->status == 'Pending' ? 'text-[#b45309]' : '' }}
                        {{ $inv->status == 'Sent' ? 'text-[#1e429f]' : '' }}
                        {{ $inv->status == 'Draft' ? 'text-[#4b5563]' : '' }}
                        {{ $inv->status == 'Overdue' ? 'text-[#c81e1e]' : '' }}">
                        {{ \Carbon\Carbon::parse($inv->tanggal_jatuh_tempo)->format('Y-m-d') }}
                    </td>
                    <td class="font-extrabold text-[#1b254b]">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge 
                            {{ $inv->status == 'Paid' ? 'badge-paid' : '' }}
                            {{ $inv->status == 'Pending' ? 'badge-pending' : '' }}
                            {{ $inv->status == 'Sent' ? 'badge-sent' : '' }}
                            {{ $inv->status == 'Draft' ? 'badge-draft' : '' }}
                            {{ $inv->status == 'Overdue' ? 'badge-overdue' : '' }}">
                            {{ $inv->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection