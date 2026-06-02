@extends('layouts.app')

@section('content')
<style>
    /* Wadah Form (Konsisten dengan modul lain) */
    .form-container {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        max-width: 900px;
    }

    /* Styling Input & Select */
    .input-field {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 20px;
        width: 100%;
        transition: all 0.3s;
        color: #1b254b;
        font-weight: 500;
        appearance: none;
    }

    .input-field:focus {
        outline: none;
        border-color: #5b80ff;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(91, 128, 255, 0.1);
    }

    .input-label {
        display: block;
        font-weight: 700;
        color: #1b254b;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper::after {
        content: '\f078';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        pointer-events: none;
    }
</style>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Tambah Invoice Baru</h2>
    <p class="text-gray-400 mt-1 font-medium">Pilih klien dan layanan untuk menerbitkan tagihan secara instan.</p>
</div>

<div class="form-container">
    <form action="{{ route('invoice.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="input-label">Pilih Klien / Customer</label>
            <div class="select-wrapper">
                <select name="id_klien" id="id_klien" class="input-field" required onchange="cekPilihanKlien(this)">
                    <option value="" disabled selected>-- Pilih Customer --</option>
                    @foreach($klien as $k)
                        <option value="{{ $k->id_klien }}">{{ $k->nama_klien }}</option>
                    @endforeach
                    <option value="new" class="font-bold text-[#5b80ff] bg-[#f4f7fe]">✨ + Tambah Klien Baru...</option>
                </select>
            </div>
        </div>

        <div id="form_klien_baru" class="hidden bg-[#f4f7fe] p-5 rounded-xl border border-[#dce4ff] mb-6">
            <p class="font-bold text-[#5b80ff] mb-4 text-sm"><i class="fas fa-user-plus mr-2"></i>Data Klien Baru</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="nama_klien_baru" id="nama_klien_baru" placeholder="Nama Perusahaan" class="input-field !py-2.5">
                <input type="email" name="email_klien_baru" id="email_klien_baru" placeholder="Email Klien" class="input-field !py-2.5">
            </div>
        </div>

        <div class="mb-8">
            <label class="input-label">Produk / Jasa</label>
            <div class="select-wrapper">
                <select name="id_produk" class="input-field" required>
                    <option value="" disabled selected>-- Pilih Produk atau Jasa --</option>
                    @foreach($produk as $p)
                        <option value="{{ $p->id_produk }}">
                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga_satuan, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <p class="text-xs text-blue-500 mt-3 font-medium italic">
                <i class="fas fa-info-circle mr-1"></i> Total tagihan akan otomatis menyesuaikan harga jasa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-4">
            <div>
                <label class="input-label">Tanggal Buat</label>
                <input type="date" name="tanggal_buat" class="input-field" value="{{ date('Y-m-d') }}" required>
            </div>

            <div>
                <label class="input-label">Jatuh Tempo</label>
                <input type="date" name="tanggal_jatuh_tempo" class="input-field" required>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-10 pt-8 border-t border-gray-100">
            <a href="{{ route('invoice.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-8 rounded-xl transition duration-300">
                Batal
            </a>
            <button type="submit" 
                    class="bg-[#5b80ff] hover:bg-blue-600 text-white font-bold py-3 px-10 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
                <i class="fas fa-save mr-2"></i> Simpan Invoice
            </button>
        </div>
    </form>
</div>

<script>
    function cekPilihanKlien(selectElement) {
        var formBaru = document.getElementById('form_klien_baru');
        var inputNama = document.getElementById('nama_klien_baru');
        var inputEmail = document.getElementById('email_klien_baru');

        if (selectElement.value === 'new') {
            // Tampilkan form
            formBaru.classList.remove('hidden');
            // Wajib diisi
            inputNama.required = true;
            inputEmail.required = true;
        } else {
            // Sembunyikan form
            formBaru.classList.add('hidden');
            // Hilangkan wajib isi
            inputNama.required = false;
            inputEmail.required = false;
            // Kosongkan value agar tidak terkirim tidak sengaja
            inputNama.value = '';
            inputEmail.value = '';
        }
    }
</script>
@endsection