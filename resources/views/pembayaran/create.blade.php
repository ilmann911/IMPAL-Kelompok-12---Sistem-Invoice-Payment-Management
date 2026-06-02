<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - InvoPay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* --- CSS ANIMASI KUSTOM --- */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-entrance {
            opacity: 0;
            animation: fadeSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-[#f4f7fe] min-h-screen flex flex-col">

    <nav class="bg-[#0b132b] p-5 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-2xl text-[#5b80ff]"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-2xl text-white tracking-wide">Portal Pelanggan</h1>
                    <p class="text-gray-400 text-sm font-medium">{{ session('nama_klien') }}</p>
                </div>
            </div>
            <a href="{{ route('portal.dashboard') }}" class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-xl transition duration-300 font-bold border border-white/5">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4 py-10">
        
        <div class="max-w-xl w-full bg-white p-8 md:p-10 rounded-2xl shadow-xl border border-gray-100 animate-entrance" style="animation-delay: 0.1s;">
            
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-credit-card text-2xl text-[#5b80ff]"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold text-[#1b254b]">Konfirmasi Pembayaran</h1>
                <p class="text-gray-500 mt-2 text-sm font-medium px-4">Selesaikan pembayaran untuk mengaktifkan layanan Anda.</p>
            </div>

            <div class="bg-blue-50/50 border border-blue-100 p-6 rounded-2xl mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[#1b254b] font-bold text-sm">No. Invoice</span>
                    <span class="font-extrabold text-[#5b80ff]">{{ $invoice->no_invoice }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[#1b254b] font-bold text-sm">Total Tagihan</span>
                    <span class="font-extrabold text-2xl text-[#1b254b]">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                    <div class="font-bold flex items-center mb-1">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Gagal Mengirim!
                    </div>
                    <ul class="list-disc pl-5 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_invoice" value="{{ $invoice->id_invoice }}">

                <div class="mb-6">
                    <label class="block text-[#1b254b] font-bold mb-2 text-sm">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full border-2 border-gray-200 p-3.5 rounded-xl focus:outline-none focus:border-[#5b80ff] focus:ring-4 focus:ring-blue-500/10 bg-gray-50 transition font-medium text-[#1b254b]" required>
                        <option value="">-- Pilih Metode Transfer --</option>
                        <option value="Transfer Bank BCA" {{ old('metode_pembayaran') == 'Transfer Bank BCA' ? 'selected' : '' }}>Transfer Bank BCA (0123456789)</option>
                        <option value="Transfer Bank Mandiri" {{ old('metode_pembayaran') == 'Transfer Bank Mandiri' ? 'selected' : '' }}>Transfer Bank Mandiri (9876543210)</option>
                        <option value="QRIS" {{ old('metode_pembayaran') == 'QRIS' ? 'selected' : '' }}>QRIS / E-Wallet</option>
                    </select>
                </div>

                <div class="mb-8">
                    <label class="block text-[#1b254b] font-bold mb-2 text-sm">Unggah Bukti Transfer</label>
                    <div class="border-2 border-gray-200 rounded-xl p-2.5 bg-gray-50 focus-within:border-[#5b80ff] focus-within:ring-4 focus-within:ring-blue-500/10 transition">
                        <input type="file" name="bukti_transfer" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-bold
                            file:bg-blue-50 file:text-[#5b80ff]
                            hover:file:bg-blue-100 cursor-pointer transition" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                    <p class="text-[11.5px] text-gray-400 mt-2 font-medium italic">*Format wajib: JPG, PNG, atau PDF (Maks. 2MB)</p>
                </div>

                <div class="flex space-x-3 md:space-x-4">
                    <a href="{{ route('portal.dashboard') }}" class="w-1/3 bg-gray-100 hover:bg-gray-200 text-[#1b254b] font-bold py-3.5 rounded-xl text-center transition flex items-center justify-center text-sm">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-[#5b80ff] hover:bg-blue-600 text-white font-extrabold py-3.5 rounded-xl shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-1 text-sm">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Konfirmasi
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>