@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center">
    <h2 class="text-2xl font-bold text-slate-800">Tambah Data Klien</h2>
</div>

<div class="bg-white rounded shadow p-6 max-w-2xl">
    <form action="{{ route('klien.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-slate-700 font-bold mb-2">Nama Klien / Perusahaan</label>
            <input type="text" name="nama_klien" class="w-full border p-3 rounded focus:outline-blue-500 bg-slate-50" placeholder="Contoh: PT Teknologi Maju" required>
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 font-bold mb-2">Email Klien</label>
            <input type="email" name="email_klien" class="w-full border p-3 rounded focus:outline-blue-500 bg-slate-50" placeholder="Contoh: info@tekano.com" required>
            
            @error('email_klien')
                <p class="text-red-500 text-sm mt-2 italic">⚠️ {{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-3">
            <a href="{{ route('klien.index') }}" class="bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded shadow">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">Simpan Klien</button>
        </div>
    </form>
</div>
@endsection