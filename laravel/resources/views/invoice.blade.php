@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kelola Invoice</h2>
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">Tambah Invoice</button>
</div>

<div class="bg-white rounded shadow p-4">
    <input type="text" placeholder="Cari Invoice..." class="w-full p-2 border rounded mb-4">
    <table class="w-full text-left">
        <tr class="bg-slate-100 border-b text-sm font-bold text-slate-600 uppercase">
            <th class="p-3">No. Invoice</th>
            <th class="p-3">Customer</th>
            <th class="p-3">Date</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
        </tr>
        @foreach($invoices as $inv)
        <tr class="border-b">
            <td class="p-3">{{ $inv->no_invoice }}</td>
            <td class="p-3">{{ $inv->klien->nama_klien }}</td>
            <td class="p-3">{{ $inv->tanggal_buat }}</td>
            <td class="p-3">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
            <td class="p-3"><span class="px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-700">{{ $inv->status }}</span></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection