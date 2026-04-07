@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6">Pembayaran</h2>

<div class="bg-white rounded shadow p-4">
    <div class="flex gap-2 mb-4">
        <input type="text" placeholder="Cari Pembayaran..." class="flex-1 p-2 border rounded">
        <button class="bg-blue-600 text-white px-6 py-2 rounded">Filter</button>
    </div>
    <table class="w-full text-left">
        <tr class="bg-slate-100 border-b text-sm font-bold text-slate-600 uppercase">
            <th class="p-3">No. Invoice</th>
            <th class="p-3">Customer</th>
            <th class="p-3">Tanggal Bayar</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
        </tr>
        @foreach($payments as $pay)
        <tr class="border-b">
            <td class="p-3">{{ $pay->invoice->no_invoice }}</td>
            <td class="p-3">{{ $pay->invoice->klien->nama_klien }}</td>
            <td class="p-3">{{ $pay->tanggal_bayar }}</td>
            <td class="p-3">Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}</td>
            <td class="p-3"><span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700">{{ $pay->status_verifikasi }}</span></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection