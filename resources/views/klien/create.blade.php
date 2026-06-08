@extends('layouts.app')

@section('content')
<style>

    .form-container {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        max-width: 800px;
    }

    .input-field {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 20px;
        width: 100%;
        transition: all 0.3s;
        color: #1b254b;
        font-weight: 500;
    }

    .input-field:focus {
        outline: none;
        border-color: #5b80ff;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(91, 128, 255, 0.1);
    }

    .input-error {
        border-color: #fc8181;
        background-color: #fff5f5;
    }

    .input-label {
        display: block;
        font-weight: 700;
        color: #1b254b;
        margin-bottom: 10px;
        font-size: 14px;
    }
</style>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-[#1b254b]">Tambah Data Klien</h2>
    <p class="text-gray-400 mt-1 font-medium">Masukkan informasi lengkap klien atau perusahaan baru Anda.</p>
</div>

<div class="form-container">
    <form action="{{ route('klien.store') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label for="nama_klien" class="input-label">Nama Klien / Perusahaan</label>
                <input type="text" name="nama_klien" id="nama_klien" 
                       value="{{ old('nama_klien') }}"
                       placeholder="Contoh: PT Teknologi Maju" 
                       class="input-field @error('nama_klien') input-error @enderror" required>
                
                @error('nama_klien')
                    <p class="text-red-500 text-sm mt-2 font-semibold flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="email_klien" class="input-label">Email Klien</label>
                <input type="email" name="email_klien" id="email_klien" 
                       value="{{ old('email_klien') }}"
                       placeholder="Contoh: info@tekano.com" 
                       class="input-field @error('email_klien') input-error @enderror" required>
                
                @error('email_klien')
                    <p class="text-red-500 text-sm mt-2 font-semibold flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-4 pt-4">
                <a href="{{ route('klien.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-8 rounded-xl transition duration-300">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-[#5b80ff] hover:bg-blue-600 text-white font-bold py-3 px-10 rounded-xl transition duration-300 shadow-md shadow-blue-500/30">
                    Simpan Klien
                </button>
            </div>
        </div>
    </form>
</div>
@endsection