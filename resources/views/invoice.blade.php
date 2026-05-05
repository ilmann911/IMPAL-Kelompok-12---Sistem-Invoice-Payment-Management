@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kelola Invoice</h2>
    <a href="{{ route('invoice.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow inline-block">Tambah Invoice</a>
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
            <th class="p-3">Aksi</th> </tr>
        @foreach($invoices as $inv)
        <tr class="border-b">
            <td class="p-3">{{ $inv->no_invoice }}</td>
            <td class="p-3">{{ $inv->klien->nama_klien }}</td>
            <td class="p-3">{{ $inv->tanggal_buat }}</td>
            <td class="p-3">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
            
            <td class="p-3">
                <span class="px-2 py-1 rounded text-xs font-bold 
                    {{ $inv->status == 'Paid' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $inv->status == 'Sent' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $inv->status == 'Draft' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $inv->status == 'Overdue' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ $inv->status }}
                </span>
            </td>

            <td class="p-3 flex space-x-2">
                @if($inv->status == 'Draft')
                    <form action="{{ route('invoice.updateStatus', $inv->id_invoice) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Sent">
                        <button class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Kirim</button>
                    </form>
                @endif
                
                @if($inv->status != 'Paid')
                    <form action="{{ route('invoice.updateStatus', $inv->id_invoice) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Paid">
                        <button class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition">Lunas</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection