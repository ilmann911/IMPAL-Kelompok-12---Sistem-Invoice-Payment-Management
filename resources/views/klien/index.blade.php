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

    .table-container { background: white; border-radius: 24px; padding: 30px 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    table th { font-size: 11px; font-weight: 800; color: #a3aed1; letter-spacing: 0.5px; border-bottom: 1px solid #f4f7fe; padding: 20px 10px; text-align: left; }
    table td { padding: 22px 10px; border-bottom: 1px solid #f4f7fe; color: #1b254b; font-size: 14px; font-weight: 600; }
    table tr:last-child td { border-bottom: none; }

    /* --- TOMBOL AKSI --- */
    /* Wrapper Aksi agar simetris */
    .aksi-wrapper { display: flex; align-items: center; gap: 12px; white-space: nowrap; }

    /* Tombol Detail (Pill) */
    .btn-detail { background-color: #f8fafc; color: #475569; border: 1px solid #e2e8f0; font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 8px; transition: all 0.2s; cursor: pointer; display: inline-flex; align-items: center; }
    .btn-detail:hover { background-color: #f1f5f9; color: #1e293b; border-color: #cbd5e1; }
    
    /* Teks Aksi (Edit/Hapus) */
    .text-edit { color: #3b82f6; font-weight: 700; font-size: 13px; text-decoration: none; }
    .text-edit:hover { color: #2563eb; text-decoration: underline; }
    .text-delete { color: #ef4444; font-weight: 700; font-size: 13px; background: none; border: none; cursor: pointer; padding: 0; }
    .text-delete:hover { color: #dc2626; text-decoration: underline; }

    /* --- CSS UNTUK MODAL POP-UP --- */
    .modal-overlay { display: none; position: fixed; z-index: 50; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(3px); }
    .modal-content { background-color: #ffffff; margin: 8% auto; padding: 35px; border-radius: 20px; width: 90%; max-width: 600px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    .close-modal { float: right; font-size: 24px; font-weight: bold; color: #94a3b8; cursor: pointer; }
    .close-modal:hover { color: #ef4444; }
    
    /* --- STYLING GRID STATISTIK MODERN --- */
    .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 24px; }
    .stat-card { padding: 20px; border-radius: 16px; display: flex; flex-direction: column; border: 1px solid #e2e8f0; background: #f8fafc; }
    .stat-total { grid-column: span 2; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-color: #bfdbfe; flex-direction: row; justify-content: space-between; align-items: center; }
    .stat-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 4px; }
    .stat-value { font-size: 18px; font-weight: 800; }
    .text-total { color: #1d4ed8; }
</style>

<div class="flex justify-between items-center mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Kelola Klien</h2>
    <a href="{{ route('klien.create') }}" class="bg-[#5b80ff] hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
        + Tambah Klien
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 font-medium border border-green-100 flex items-center animate-entrance" style="animation-delay: 0.2s;">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif

<div class="table-container animate-entrance" style="animation-delay: 0.3s;">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="uppercase">
                <th class="w-20">ID</th>
                <th>Nama Klien</th>
                <th>Email Klien</th>
                <th class="col-aksi">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kliens as $k)
            <tr class="hover:bg-[#f4f7fe]/50 transition-colors">
                <td class="font-bold text-[#a3aed1]">#{{ $loop->iteration }}</td>
                <td class="font-extrabold text-[#1b254b]">{{ $k->nama_klien }}</td>
                <td class="font-medium text-gray-500">{{ $k->email_klien }}</td>
                <td>
                    <div class="aksi-wrapper">
                        <button type="button" class="btn-detail" onclick="openModal('modal-klien-{{ $k->id_klien ?? $k->id }}')">Detail</button>
                        
                        <a href="{{ route('klien.edit', $k->id_klien ?? $k->id) }}" class="text-edit">Edit</a>
                        
                        <form action="{{ route('klien.destroy', $k->id_klien ?? $k->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus klien ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-delete">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($kliens as $k)
<div id="modal-klien-{{ $k->id_klien ?? $k->id }}" class="modal-overlay">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modal-klien-{{ $k->id_klien ?? $k->id }}')">&times;</span>
        <h3 class="text-2xl font-extrabold text-[#1b254b] mb-1">Rincian Tagihan</h3>
        <p class="text-sm text-gray-500 mb-6">{{ $k->nama_klien }} &bull; {{ $k->email_klien }}</p>
        
        @php
            $totalInvoices = $k->invoices->count() ?? 0;
            $totalNominal = $k->invoices->sum('total') ?? 0;
            $totalPaid = $k->invoices->where('status', 'Paid')->sum('total') ?? 0;
            $totalDraft = $k->invoices->where('status', 'Draft')->sum('total') ?? 0;
            $totalOverdue = $k->invoices->where('status', 'Overdue')->sum('total') ?? 0;
            $totalPending = $k->invoices->whereIn('status', ['Pending', 'Sent'])->sum('total') ?? 0;
        @endphp

        <div class="stats-grid">
            <div class="stat-card stat-total">
                <div>
                    <div class="stat-label text-blue-800">Total Nilai Proyek</div>
                    <div class="text-[11px] text-blue-400 font-bold">Dari {{ $totalInvoices }} Invoice</div>
                </div>
                <div class="text-2xl font-extrabold text-blue-800">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card" style="background:#f0fdf4; border-color:#bbf7d0;">
                <div class="stat-label" style="color:#15803d;">Sudah Dibayar</div>
                <div class="stat-value" style="color:#15803d;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card" style="background:#fffbeb; border-color:#fef08a;">
                <div class="stat-label" style="color:#b45309;">Menunggu</div>
                <div class="stat-value" style="color:#b45309;">Rp {{ number_format($totalPending, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card" style="background:#f8fafc; border-color:#e2e8f0;">
                <div class="stat-label" style="color:#475569;">Draft</div>
                <div class="stat-value" style="color:#475569;">Rp {{ number_format($totalDraft, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card" style="background:#fef2f2; border-color:#fecaca;">
                <div class="stat-label" style="color:#b91c1c;">Jatuh Tempo</div>
                <div class="stat-value" style="color:#b91c1c;">Rp {{ number_format($totalOverdue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    function openModal(id) { document.getElementById(id).style.display = 'block'; document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = 'auto'; }
    window.onclick = function(e) { if (e.target.classList.contains('modal-overlay')) closeModal(e.target.id); }
</script>
@endsection