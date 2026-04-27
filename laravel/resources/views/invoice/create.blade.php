<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Invoice - InvoPay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <div class="w-64 bg-[#1e222d] text-white flex flex-col justify-between">
        <div>
            <div class="p-6 bg-white text-blue-600 font-bold text-2xl flex items-center">
                <span class="mr-2">📄</span> InvoPay
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard') }}" class="block px-6 py-3 text-slate-300 hover:bg-slate-800">Dashboard</a>
                <a href="{{ route('klien.index') }}" class="block px-6 py-3 text-slate-300 hover:bg-slate-800">Kelola Klien</a>
                <a href="{{ route('produk.index') }}" class="block px-6 py-3 text-slate-300 hover:bg-slate-800">Kelola Produk</a>
                <a href="{{ route('invoice.index') }}" class="block px-6 py-3 bg-blue-600 text-white font-semibold">Kelola Invoice</a>
                <a href="#" class="block px-6 py-3 text-slate-300 hover:bg-slate-800">Pembayaran</a>
                <a href="#" class="block px-6 py-3 text-slate-300 hover:bg-slate-800">Laporan</a>
            </nav>
        </div>
        <div class="p-6">
            <a href="#" class="text-red-400 hover:text-red-500">Logout</a>
        </div>
    </div>

    <div class="flex-1 flex flex-col bg-blue-400 overflow-y-auto">
        <header class="bg-white px-6 py-4 flex justify-between items-center shadow">
            <h2 class="text-xl font-bold text-gray-800">Tambah Invoice Baru</h2>
            <span class="text-gray-600 text-sm font-semibold">Admin InvoPay</span>
        </header>

        <div class="p-8 flex justify-center">
            <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
                
                <form action="{{ route('invoice.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Pilih Klien / Customer</label>
                        <select name="id_klien" id="id_klien" class="w-full border p-3 rounded-lg focus:outline-blue-500 bg-gray-50" required onchange="cekPilihanKlien(this)">
                            <option value="">-- Pilih Customer --</option>
                            @foreach($klien as $k)
                                <option value="{{ $k->id_klien }}">{{ $k->nama_klien }}</option>
                            @endforeach
                            <option value="new" class="font-bold text-blue-600 bg-blue-50">✨ + Tambah Klien Baru...</option>
                        </select>
                    </div>

                    <div id="form_klien_baru" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-200 mb-4">
                        <p class="font-bold text-blue-800 mb-2 text-sm text-center">Data Klien Baru</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="nama_klien_baru" id="nama_klien_baru" placeholder="Nama Perusahaan" class="w-full border p-2 rounded focus:outline-blue-500">
                            <input type="email" name="email_klien_baru" id="email_klien_baru" placeholder="Email Klien" class="w-full border p-2 rounded focus:outline-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Produk / Jasa</label>
                        <select name="id_produk" class="w-full border p-3 rounded-lg focus:outline-blue-500 bg-gray-50" required>
                            <option value="">-- Pilih Produk atau Jasa --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}">
                                    {{ $p->nama_produk }} - (Rp {{ number_format($p->harga_satuan, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-2 italic">Total tagihan akan otomatis menyesuaikan dengan harga jasa yang dipilih.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Buat</label>
                            <input type="date" name="tanggal_buat" class="w-full border p-3 rounded-lg focus:outline-blue-500 bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jatuh Tempo</label>
                            <input type="date" name="tanggal_jatuh_tempo" class="w-full border p-3 rounded-lg focus:outline-blue-500 bg-gray-50" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('invoice.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded shadow transition">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            Simpan Invoice
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function cekPilihanKlien(selectElement) {
            var formBaru = document.getElementById('form_klien_baru');
            var inputNama = document.getElementById('nama_klien_baru');
            var inputEmail = document.getElementById('email_klien_baru');

            if (selectElement.value === 'new') {
                formBaru.classList.remove('hidden');
                inputNama.required = true;
                inputEmail.required = true;
            } else {
                formBaru.classList.add('hidden');
                inputNama.required = false;
                inputEmail.required = false;
                inputNama.value = '';
                inputEmail.value = '';
            }
        }
    </script>
</body>
</html>