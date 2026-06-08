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

    .form-container { 
        background: white; 
        border-radius: 24px; 
        padding: 40px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.02); 
        max-width: 800px; 
    }
    
    .form-label { 
        font-size: 12px; 
        font-weight: 800; 
        color: #64748b; 
        text-transform: uppercase; 
        letter-spacing: 0.5px; 
        margin-bottom: 8px; 
        display: block; 
    }
    
    .form-input { 
        width: 100%; 
        background-color: #f8fafc; 
        border: 1px solid #e2e8f0; 
        border-radius: 12px; 
        padding: 14px 20px; 
        font-size: 14px; 
        color: #1b254b; 
        font-weight: 600; 
        transition: all 0.3s; 
        margin-bottom: 24px; 
    }
    
    .form-input:focus { 
        outline: none; 
        border-color: #5b80ff; 
        background-color: white; 
        box-shadow: 0 0 0 4px rgba(91, 128, 255, 0.1); 
    }

    .form-input:disabled { 
        background-color: #f1f5f9; 
        color: #94a3b8; 
        cursor: not-allowed; 
        border-color: #e2e8f0;
    }

    .input-editable {
        background-color: #eff6ff;
        border-color: #bfdbfe;
    }
</style>

<div class="flex items-center gap-4 mb-8 animate-entrance" style="animation-delay: 0.1s;">
    <a href="{{ route('invoice.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-blue-600 hover:shadow-md transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Perpanjang Jatuh Tempo</h2>
</div>

<div class="form-container animate-entrance" style="animation-delay: 0.2s;">
    <form action="{{ route('invoice.update', $invoice->id_invoice ?? $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
            <div>
                <label class="form-label">No. Invoice</label>
                <input type="text" class="form-input" value="{{ $invoice->no_invoice }}" disabled>
            </div>

            <div>
                <label class="form-label">Ditagihkan Kepada</label>
                <input type="text" class="form-input" value="{{ $invoice->klien->nama_klien ?? '-' }}" disabled>
            </div>

            <div>
                <label class="form-label">Tanggal Terbit</label>
                <input type="date" class="form-input" value="{{ \Carbon\Carbon::parse($invoice->tanggal_buat)->format('Y-m-d') }}" disabled>
            </div>

            <div>
                <label class="form-label text-blue-600">Tanggal Jatuh Tempo (Ubah Di Sini)</label>
                <input type="date" name="tanggal_jatuh_tempo" class="form-input input-editable" value="{{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->format('Y-m-d') }}" required>
            </div>

            <div>
                <label class="form-label">Status Saat Ini</label>
                <input type="text" class="form-input" value="{{ $invoice->status }}" disabled>
            </div>

            <div>
                <label class="form-label">Total Tagihan</label>
                <input type="text" class="form-input" value="Rp {{ number_format($invoice->total, 0, ',', '.') }}" disabled>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-2 border-t border-gray-100 pt-6">
            <a href="{{ route('invoice.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl font-bold text-white bg-[#5b80ff] hover:bg-blue-600 shadow-md shadow-blue-500/30 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection