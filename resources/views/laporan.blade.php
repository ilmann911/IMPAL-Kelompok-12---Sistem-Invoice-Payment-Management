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

    /* --- STYLING KARTU METRIK --- */
    .card-solid {
        border-radius: 16px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 120px;
    }
    
    .card-solid::after {
        content: ''; position: absolute; right: -20px; bottom: -20px;
        width: 110px; height: 110px; background: rgba(255, 255, 255, 0.15); border-radius: 50%;
    }

    .bg-blue-solid { background-color: #5b80ff; }
    .bg-green-solid { background-color: #48bb78; }
    .bg-gray-solid { background-color: #a0aec0; }
    .bg-red-solid { background-color: #fc8181; }

    .solid-title { font-size: 13px; font-weight: 600; margin-bottom: 8px; opacity: 0.9; }
    .solid-value { font-size: 32px; font-weight: 800; line-height: 1; }

    /* Wadah Konten Putih */
    .content-card {
        background: white; border-radius: 20px; padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #f4f7fe;
    }
    
    /* Styling Tabel Riwayat */
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; border-bottom: 1px solid #f4f7fe; padding-bottom: 15px; }
    table td { padding: 15px 0; border-bottom: 1px solid #f4f7fe; font-size: 13px; font-weight: 600;}
    table tr:last-child td { border-bottom: none; }
    .badge-paid { background-color: #def7ec; color: #057a55; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; }
</style>

<div class="flex justify-between items-end mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <div>
        <h2 class="text-3xl font-extrabold text-[#1b254b] mb-2">Laporan Keuangan</h2>
    </div>
    <a href="{{ route('laporan.export') }}" target="_blank" class="bg-[#1b254b] hover:bg-gray-800 text-white font-bold py-2.5 px-6 rounded-xl transition duration-300 shadow-lg text-sm flex items-center">
        <i class="fas fa-file-pdf mr-2 text-red-400"></i> Export Laporan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="card-solid bg-blue-solid animate-entrance" style="animation-delay: 0.2s;">
        <div class="solid-title">Total Invoice</div>
        <div class="solid-value">{{ $totalInvoice }}</div>
    </div>
    <div class="card-solid bg-green-solid animate-entrance" style="animation-delay: 0.3s;">
        <div class="solid-title">Paid</div>
        <div class="solid-value">{{ $paid }}</div>
    </div>
    <div class="card-solid bg-gray-solid animate-entrance" style="animation-delay: 0.4s;">
        <div class="solid-title">Unpaid / Pending</div>
        <div class="solid-value">{{ $unpaid }}</div>
    </div>
    <div class="card-solid bg-red-solid animate-entrance" style="animation-delay: 0.5s;">
        <div class="solid-title">Overdue</div>
        <div class="solid-value">{{ $overdue }}</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    
    <div class="content-card flex flex-col justify-center items-center py-8 animate-entrance" style="animation-delay: 0.6s;">
        <h4 class="text-gray-500 font-bold text-[14px] text-center mb-3">Pendapatan (Lunas)</h4>
        <div class="text-[30px] md:text-[32px] font-extrabold text-[#48bb78] tracking-tight text-center">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </div>
    </div>

    <div class="content-card flex flex-col justify-center items-center py-8 animate-entrance" style="animation-delay: 0.61s;">
        <h4 class="text-gray-500 font-bold text-[14px] text-center mb-3">Total Piutang (Belum Lunas)</h4>
        <div class="text-[30px] md:text-[32px] font-extrabold text-[#a0aec0] tracking-tight text-center">
            Rp {{ number_format($totalPiutang, 0, ',', '.') }}
        </div>
    </div>

    <div class="content-card flex flex-col justify-center items-center py-8 animate-entrance" style="animation-delay: 0.62s;">
        <h4 class="text-gray-500 font-bold text-[14px] text-center mb-3">Piutang Macet (Overdue)</h4>
        <div class="text-[30px] md:text-[32px] font-extrabold text-[#fc8181] tracking-tight text-center">
            Rp {{ number_format($totalOverdueNominal, 0, ',', '.') }}
        </div>
    </div>

</div>

<div class="mb-6 animate-entrance" style="animation-delay: 0.63s;">
    <div class="content-card flex flex-col justify-center items-center py-8 w-full border-t-4 border-[#5b80ff]">
        <h4 class="text-gray-500 font-bold text-[15px] text-center mb-3 uppercase tracking-wider">Total Invoice (Keseluruhan)</h4>
        <div class="text-[36px] md:text-[40px] font-extrabold text-[#5b80ff] tracking-tight text-center">
            Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
        </div>
    </div>
</div>

<div class="mb-6 animate-entrance" style="animation-delay: 0.65s;">
    <div class="content-card flex flex-col justify-center w-full">
        <h4 class="text-[#1b254b] font-extrabold text-sm uppercase tracking-wider mb-5 flex items-center">
            <i class="fas fa-crown text-yellow-500 mr-2 text-lg"></i> Top Klien
        </h4>
        <div class="space-y-4">
            @if(isset($topKliens) && count($topKliens) > 0)
                @foreach($topKliens as $tk)
                <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                    <span class="font-bold text-gray-700 text-sm truncate max-w-[120px]">{{ $tk->nama_klien }}</span>
                    <span class="font-bold text-[#5b80ff] text-sm">Rp {{ number_format($tk->total, 0, ',', '.') }}</span>
                </div>
                @endforeach
            @else
                <div class="text-center text-sm text-gray-400 py-4 italic">Belum ada data klien lunas.</div>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-10">
    
    <div class="content-card flex flex-col h-[28rem] animate-entrance" style="animation-delay: 0.7s;">
        <h4 class="text-[#1b254b] font-extrabold text-lg mb-4 w-full">Persentase Status Invoice</h4>
        <div class="relative w-full flex-1 min-h-0 pb-2">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <div class="content-card flex flex-col h-[28rem] animate-entrance" style="animation-delay: 0.8s;">
        <h4 class="text-[#1b254b] font-extrabold text-lg mb-6">Riwayat Transaksi (Lunas)</h4>
        
        <div class="overflow-y-auto pr-2 flex-1 min-h-0">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white shadow-sm z-10">
                    <tr class="uppercase">
                        <th class="px-2">Invoice</th>
                        <th class="px-2">Klien</th>
                        <th class="px-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInvoices as $inv)
                    <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                        <td class="font-extrabold text-[#5b80ff] px-2">{{ $inv->no_invoice }}</td>
                        <td class="text-gray-500 text-xs font-bold px-2">{{ $inv->nama_klien }}</td>
                        <td class="px-2 text-center">
                            <span class="badge-paid">{{ $inv->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-slate-400 italic">Belum ada transaksi yang lunas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid/Pending', 'Overdue'],
            datasets: [{
                data: [{{ $paid }}, {{ $unpaid }}, {{ $overdue }}],
                backgroundColor: ['#48bb78', '#a0aec0', '#fc8181'], 
                borderWidth: 4, 
                borderColor: '#ffffff', 
                hoverOffset: 12, 
                borderRadius: 5 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%', 
            animation: {
                animateScale: true,   
                animateRotate: true,  
                duration: 2000,       
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        padding: 25,
                        font: {
                            family: "'Inter', sans-serif",
                            weight: 'bold',
                            size: 11
                        },
                        color: '#6b7280'
                    }
                } 
            },
            layout: {
                padding: { bottom: 10 }
            }
        }
    });
</script>
@endsection