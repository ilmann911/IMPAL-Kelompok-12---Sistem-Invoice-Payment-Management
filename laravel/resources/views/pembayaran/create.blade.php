<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - InvoPay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="max-w-xl w-full bg-white p-10 rounded-3xl shadow-2xl border border-slate-100">
        
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">💳</div>
            <h1 class="text-3xl font-extrabold text-slate-800">Konfirmasi Pembayaran</h1>
            <p class="text-slate-500 mt-2">Selesaikan pembayaran untuk mengaktifkan layanan Anda.</p>
        </div>

        <div class="bg-blue-50 border border-blue-100 p-6 rounded-2xl mb-8">
            <div class="flex justify-between items-center mb-2">
                <span class="text-slate-600 font-semibold">No. Invoice</span>
                <span class="font-extrabold text-blue-700">{{ $invoice->no_invoice }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-600 font-semibold">Total Tagihan</span>
                <span class="font-extrabold text-2xl text-slate-800">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_invoice" value="{{ $invoice->id_invoice }}">

            <div class="mb-6">
                <label class="block text-slate-700 font-extrabold mb-2">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full border-2 border-slate-200 p-4 rounded-xl focus:outline-none focus:border-blue-500 bg-slate-50 transition font-medium text-slate-700" required>
                    <option value="">-- Pilih Metode Transfer --</option>
                    <option value="Transfer Bank BCA">Transfer Bank BCA (0123456789)</option>
                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri (9876543210)</option>
                    <option value="QRIS">QRIS / E-Wallet</option>
                </select>
            </div>

            <div class="mb-8">
                <label class="block text-slate-700 font-extrabold mb-2">Unggah Bukti Transfer</label>
                <div class="border-2 border-slate-300 rounded-xl p-4 bg-slate-50">
                    <input type="file" name="bukti_transfer" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-bold
                        file:bg-blue-100 file:text-blue-700
                        hover:file:bg-blue-200 cursor-pointer transition" accept="image/png, image/jpeg, application/pdf" required>
                </div>
                <p class="text-xs text-slate-400 mt-2">*Format wajib: JPG, PNG, atau PDF (Maks. 2MB)</p>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('portal.dashboard') }}" class="w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-4 rounded-xl text-center transition">Batal</a>
                <button type="submit" class="w-2/3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-4 rounded-xl shadow-lg hover:shadow-blue-500/50 transition transform hover:-translate-y-1">
                    Kirim Konfirmasi
                </button>
            </div>
        </form>

    </div>

</body>
</html>