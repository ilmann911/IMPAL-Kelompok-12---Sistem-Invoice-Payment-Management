@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Riwayat Pembayaran</h2>
    <div class="flex space-x-2">
        <input type="text" placeholder="Cari Pembayaran..." class="border p-2 rounded-lg text-sm w-64 focus:outline-blue-500">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">Filter</button>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm border border-green-300">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-100 border-b text-sm font-bold text-slate-600 uppercase">
                <th class="p-4">No. Invoice</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Tanggal Bayar</th>
                <th class="p-4 text-right">Total</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Aksi & Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $bayar)
            <tr class="border-b hover:bg-slate-50 transition">
                <td class="p-4 font-semibold text-blue-600">
                    {{ $bayar->no_invoice }}
                </td>
                <td class="p-4 text-slate-700">
                    {{ $bayar->nama_klien }}
                </td>
                <td class="p-4 text-slate-600 text-sm">
                    {{ \Carbon\Carbon::parse($bayar->tanggal_bayar ?? $bayar->created_at)->format('d M Y') }}
                </td>
                <td class="p-4 text-right font-medium">
                    Rp {{ number_format($bayar->total, 0, ',', '.') }}
                </td>
                <td class="p-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                        {{ $bayar->status == 'Paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $bayar->status == 'Pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ $bayar->status }}
                    </span>
                </td>
                
                <td class="p-4 text-center">
                    <div class="flex flex-col items-center space-y-2">
                        @if(isset($bayar->bukti_transfer) && $bayar->bukti_transfer != '')
                            <a href="{{ asset('uploads/bukti/' . $bayar->bukti_transfer) }}" target="_blank" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1 rounded text-xs font-bold transition w-full text-center">
                                👁️ Lihat Bukti
                            </a>
                        @else
                            <span class="text-slate-400 italic text-xs">Tidak ada bukti</span>
                        @endif

                        @if($bayar->status == 'Pending')
                            <form action="{{ route('pembayaran.verify', $bayar->id_pembayaran) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold transition w-full shadow-sm" onclick="return confirm('Verifikasi pembayaran ini? Status invoice akan otomatis menjadi Lunas (Paid).')">
                                    ✅ Verifikasi
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-10 text-center text-slate-400 italic">
                    Belum ada data pembayaran yang tercatat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 text-sm text-slate-500 italic">
    * Data ini disinkronkan otomatis saat pelanggan mengunggah bukti pembayaran. Admin memverifikasi bukti yang berstatus "Pending".
</div>
@endsection