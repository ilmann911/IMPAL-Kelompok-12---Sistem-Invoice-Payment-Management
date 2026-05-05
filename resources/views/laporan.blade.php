@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6">Laporan Keuangan</h2>

<div class="grid grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded shadow border-t-4 border-blue-500">
        <p class="text-sm font-bold text-slate-500">Total Invoice</p>
        <p class="text-2xl font-bold">{{ $totalInvoice }}</p>
    </div>
    <div class="bg-green-500 p-4 rounded shadow text-white">
        <p class="text-sm font-bold">Paid</p>
        <p class="text-2xl font-bold">{{ $paid }}</p>
    </div>
    <div class="bg-slate-400 p-4 rounded shadow text-white">
        <p class="text-sm font-bold">Unpaid / Pending</p>
        <p class="text-2xl font-bold">{{ $unpaid }}</p>
    </div>
    <div class="bg-red-500 p-4 rounded shadow text-white">
        <p class="text-sm font-bold">Overdue</p>
        <p class="text-2xl font-bold">{{ $overdue }}</p>
    </div>
</div>

<div class="bg-white p-8 rounded shadow text-center border-t-4 border-green-500 mb-8">
    <p class="text-lg font-bold text-slate-500 mb-2">Total Pendapatan (Invoice Lunas)</p>
    <p class="text-4xl font-extrabold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded shadow flex flex-col h-[28rem]">
        <h3 class="font-bold text-slate-700 mb-4">Grafik Status Invoice</h3>
        <div class="relative w-full flex-1 min-h-0 pb-2">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded shadow flex flex-col h-[28rem]">
        <h3 class="font-bold text-slate-700 mb-4">Riwayat Transaksi (Lunas)</h3>
        <div class="overflow-y-auto pr-2 flex-1 min-h-0">
            <table class="w-full text-sm text-left">
                <thead class="sticky top-0 bg-white shadow-sm z-10">
                    <tr class="text-slate-500 border-b">
                        <th class="p-3 bg-white">Invoice</th>
                        <th class="p-3 bg-white">Klien</th>
                        <th class="p-3 text-center bg-white">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInvoices as $inv)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-3 font-semibold text-blue-600">{{ $inv->no_invoice }}</td>
                        <td class="p-3">{{ $inv->nama_klien }}</td>
                        <td class="p-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                {{ $inv->status }}
                            </span>
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
        type: 'pie',
        data: {
            labels: ['Paid', 'Unpaid/Pending', 'Overdue'],
            datasets: [{
                data: [{{ $paid }}, {{ $unpaid }}, {{ $overdue }}],
                backgroundColor: ['#22c55e', '#94a3b8', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        padding: 20 // Memberikan jarak agar tidak terlalu mepet
                    }
                } 
            },
            layout: {
                padding: {
                    bottom: 10 // Memberikan jarak dari tepi bawah
                }
            }
        }
    });
</script>
@endsection