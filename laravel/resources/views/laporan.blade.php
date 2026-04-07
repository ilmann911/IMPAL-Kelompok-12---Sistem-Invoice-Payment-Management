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
        <p class="text-sm font-bold">Unpaid</p>
        <p class="text-2xl font-bold">{{ $unpaid }}</p>
    </div>
    <div class="bg-red-500 p-4 rounded shadow text-white">
        <p class="text-sm font-bold">Overdue</p>
        <p class="text-2xl font-bold">{{ $overdue }}</p>
    </div>
</div>

<div class="bg-white p-20 rounded shadow text-center text-slate-400">
    Grafik Laporan (Akan diimplementasikan pada tahap selanjutnya)
</div>
@endsection