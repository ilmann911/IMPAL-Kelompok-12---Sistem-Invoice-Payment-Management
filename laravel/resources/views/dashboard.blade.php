@extends('layouts.app')

@section('content')
<div class="grid grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded shadow border-t-4 border-blue-500 p-4">
        <h3 class="text-sm font-bold text-slate-700">Total Invoice</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalInvoice }}</p>
    </div>
    <div class="bg-green-500 rounded shadow p-4 text-white">
        <h3 class="text-sm font-bold">Paid</h3>
        <p class="text-3xl font-bold mt-2">{{ $paid }}</p>
    </div>
    <div class="bg-slate-400 rounded shadow p-4 text-white">
        <h3 class="text-sm font-bold">Unpaid</h3>
        <p class="text-3xl font-bold mt-2">{{ $unpaid }}</p>
    </div>
    <div class="bg-red-500 rounded shadow p-4 text-white">
        <h3 class="text-sm font-bold">Overdue</h3>
        <p class="text-3xl font-bold mt-2">{{ $overdue }}</p>
    </div>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-100 text-slate-600 text-sm uppercase border-b">
                <th class="p-4">No. Invoice</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Date</th>
                <th class="p-4">Total</th>
                <th class="p-4">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $inv)
            <tr class="border-b hover:bg-slate-50">
                <td class="p-4 font-semibold text-slate-800">{{ $inv->no_invoice }}</td>
                <td class="p-4">{{ $inv->klien->nama_klien ?? 'Tidak Diketahui' }}</td> 
                <td class="p-4">{{ $inv->tanggal_buat }}</td>
                <td class="p-4">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs font-bold rounded 
                        {{ $inv->status == 'Paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $inv->status == 'Sent' || $inv->status == 'Draft' ? 'bg-slate-200 text-slate-700' : '' }}
                        {{ $inv->status == 'Overdue' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ $inv->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection