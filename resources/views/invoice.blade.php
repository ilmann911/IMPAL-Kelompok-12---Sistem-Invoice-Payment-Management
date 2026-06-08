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
        border-radius: 24px;
        padding: 30px 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; letter-spacing: 0.5px; border-bottom: 1px solid #f4f7fe; padding-bottom: 20px; text-align: left; }
    table td { padding: 22px 0; border-bottom: 1px solid #f4f7fe; color: #1b254b; font-size: 14px; font-weight: 600;}
    table tr:last-child td { border-bottom: none; }

    .search-input {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 20px;
        width: 100%;
        transition: all 0.3s;
        font-size: 14px;
        color: #1b254b;
    }
    .search-input:focus {
        outline: none;
        border-color: #5b80ff;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(91, 128, 255, 0.1);
    }

    .badge { padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; text-align: center; }
    .badge-paid { background-color: #def7ec; color: #057a55; }
    .badge-draft { background-color: #f3f4f6; color: #4b5563; }
    .badge-sent { background-color: #e1effe; color: #1e429f; }
    .badge-overdue { background-color: #fde8e8; color: #c81e1e; }
    .badge-pending { background-color: #fef3c7; color: #b45309; }

    .btn-action { font-size: 12px; font-weight: 700; padding: 6px 0; border-radius: 8px; transition: all 0.2s; display: block; width: 100%; text-align: center; box-sizing: border-box; }
    .btn-blue { background-color: #3b82f6; color: white; border: none; cursor: pointer; }
    .btn-blue:hover { background-color: #2563eb; }
    
    .btn-detail { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; cursor: pointer; padding: 6px 14px; width: auto; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; border-radius: 8px; transition: all 0.2s; }
    .btn-detail:hover { background-color: #e2e8f0; color: #1e293b; }

    .text-edit { color: #3b82f6; font-weight: 700; font-size: 13px; text-decoration: none; }
    .text-edit:hover { color: #2563eb; text-decoration: underline; }
    .text-delete { color: #ef4444; font-weight: 700; font-size: 13px; background: none; border: none; cursor: pointer; padding: 0; }
    .text-delete:hover { color: #dc2626; text-decoration: underline; }

    .modal-overlay { display: none; position: fixed; z-index: 50; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(3px); }
    .modal-content { background-color: #ffffff; margin: 8% auto; padding: 30px; border-radius: 16px; width: 90%; max-width: 600px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: slideDown 0.3s ease-out; }
    @keyframes slideDown { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .close-modal { float: right; font-size: 24px; font-weight: bold; color: #94a3b8; cursor: pointer; transition: 0.2s; line-height: 1; }
    .close-modal:hover { color: #ef4444; }
    
    .detail-table th { background-color: #f8fafc; padding: 10px; font-size: 10px; color: #64748b; border-bottom: none; }
    .detail-table td { padding: 10px; font-size: 12px; border-bottom: 1px solid #f1f5f9; }
</style>

<div class="flex justify-between items-center mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Kelola Invoice</h2>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('invoice.create') }}" class="bg-[#5b80ff] hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
            + Tambah Invoice
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 font-medium border border-green-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 font-medium border border-red-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
@endif

<div class="table-container animate-entrance" style="animation-delay: 0.3s;">
    
    <form action="{{ route('invoice.index') }}" method="GET" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Invoice, Klien, atau Status lalu tekan Enter..." class="search-input w-full">
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="uppercase">
                    <th class="px-2">No. Invoice</th>
                    <th class="px-2">Customer</th>
                    <th class="px-2">Tgl Terbit</th>
                    <th class="px-2">Jatuh Tempo</th>
                    <th class="px-2">Total</th>
                    <th class="px-2 text-center">Status</th>
                    <th class="px-2" style="width: 290px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($invoices as $inv)
                <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                    <td class="font-extrabold text-[#1b254b] px-2">{{ $inv->no_invoice }}</td>
                    <td class="font-medium text-gray-500 px-2">{{ $inv->klien->nama_klien ?? 'Tidak Diketahui' }}</td> 
                    <td class="font-medium text-gray-500 px-2">{{ \Carbon\Carbon::parse($inv->tanggal_buat)->format('Y-m-d') }}</td>
                    <td class="font-bold px-2 
                        {{ $inv->status == 'Paid' ? 'text-[#057a55]' : '' }}
                        {{ $inv->status == 'Pending' ? 'text-[#b45309]' : '' }}
                        {{ $inv->status == 'Sent' ? 'text-[#1e429f]' : '' }}
                        {{ $inv->status == 'Draft' ? 'text-[#4b5563]' : '' }}
                        {{ $inv->status == 'Overdue' ? 'text-[#c81e1e]' : '' }}">
                        {{ \Carbon\Carbon::parse($inv->tanggal_jatuh_tempo)->format('Y-m-d') }}
                    </td>
                    <td class="font-extrabold text-[#1b254b] px-2">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                    <td class="px-2 text-center">
                        <span class="badge 
                            {{ $inv->status == 'Paid' ? 'badge-paid' : '' }}
                            {{ $inv->status == 'Pending' ? 'badge-pending' : '' }}
                            {{ $inv->status == 'Sent' ? 'badge-sent' : '' }}
                            {{ $inv->status == 'Draft' ? 'badge-draft' : '' }}
                            {{ $inv->status == 'Overdue' ? 'badge-overdue' : '' }}">
                            {{ $inv->status }}
                        </span>
                    </td>
                    <td class="px-2">
                        <div class="flex items-center justify-between w-full">
                            
                            <div class="flex items-center gap-3 w-24 flex-shrink-0">
                                <a href="{{ route('invoice.edit', $inv->id_invoice ?? $inv->id) }}" class="text-edit">Edit</a>
                                
                                <form action="{{ route('invoice.destroy', $inv->id_invoice ?? $inv->id) }}" method="POST" class="m-0 p-0 flex items-center" onsubmit="return confirm('Yakin ingin menghapus invoice ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-delete">Hapus</button>
                                </form>
                            </div>

                            <div class="flex items-center gap-3 flex-shrink-0">
                                <div class="w-[75px] flex-shrink-0 flex justify-center items-center">
                                    @if($inv->status == 'Draft')
                                        <form action="{{ route('invoice.updateStatus', $inv->id_invoice ?? $inv->id) }}" method="POST" class="m-0 p-0 w-full">
                                            @csrf
                                            <input type="hidden" name="status" value="Sent">
                                            <button type="submit" class="btn-action btn-blue">Kirim</button>
                                        </form>
                                    @else
                                        <span class="text-gray-300 font-bold text-lg">-</span>
                                    @endif
                                </div>

                                <button type="button" class="btn-detail flex-shrink-0" onclick="openModal('modal-{{ $inv->id_invoice ?? $inv->id }}')">Detail</button>
                            </div>
                            
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500 font-medium">
                        <i class="fas fa-search text-2xl mb-2 text-gray-300 block"></i>
                        Data invoice tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@foreach($invoices as $inv)
<div id="modal-{{ $inv->id_invoice ?? $inv->id }}" class="modal-overlay">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modal-{{ $inv->id_invoice ?? $inv->id }}')">&times;</span>
        
        <h3 class="text-xl font-extrabold text-[#1b254b] mb-1">Detail Invoice</h3>
        <p class="text-sm text-gray-500 mb-5">{{ $inv->no_invoice }} &bull; Dibuat oleh: {{ $inv->admin->nama_admin ?? 'Sistem' }}</p>
        
        <div class="mb-4">
            <p class="text-xs text-gray-400 font-bold uppercase">Ditagihkan Kepada:</p>
            <p class="font-bold text-[#1b254b]">{{ $inv->klien->nama_klien ?? '-' }}</p>
        </div>

        <table class="w-full text-left detail-table mb-4">
            <thead>
                <tr>
                    <th>NAMA LAYANAN / PRODUK</th>
                    <th class="text-right">HARGA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inv->details as $detail)
                <tr>
                    <td class="font-bold text-[#1b254b]">{{ $detail->produk->nama_produk ?? $detail->nama_produk ?? 'Item' }}</td>
                    <td class="text-right font-bold text-[#1b254b]">Rp {{ number_format($detail->harga_jual_saat_ini, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="2" class="text-center text-gray-400">Tidak ada detail item.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="flex justify-between items-center bg-[#f8fafc] p-4 rounded-xl border border-[#e2e8f0]">
            <span class="text-sm font-bold text-gray-500">TOTAL KESELURUHAN:</span>
            <span class="text-lg font-extrabold text-[#5b80ff]">Rp {{ number_format($inv->total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endforeach

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
        document.body.style.overflow = 'hidden'; 
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto'; 
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = "none";
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection