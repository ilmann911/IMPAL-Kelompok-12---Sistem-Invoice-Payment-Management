<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvoPay - Sistem Manajemen Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-96 bg-blue-600 rounded-b-[100px] shadow-lg"></div>

    <div class="relative z-10 bg-white p-10 rounded-2xl shadow-2xl max-w-3xl w-full mx-4 text-center border border-slate-100">
        <div class="flex justify-center mb-4">
            <span class="text-5xl">📄</span>
        </div>
        <h1 class="text-4xl font-extrabold text-slate-800 mb-2">Selamat Datang di <span class="text-blue-600">InvoPay</span></h1>
        <p class="text-slate-500 mb-10 text-lg">Sistem Invoice & Payment Management Terintegrasi</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('portal.login') }}" class="group block p-6 border-2 border-slate-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition duration-300">
                <div class="text-4xl mb-3 group-hover:scale-110 transition">🧑‍💼</div>
                <h2 class="text-xl font-bold text-slate-700 mb-2">Portal Pelanggan</h2>
                <p class="text-sm text-slate-500">Cek tagihan dan konfirmasi bukti pembayaran Anda di sini.</p>
                <div class="mt-4 inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-bold group-hover:bg-blue-600 group-hover:text-white transition">
                    Masuk Portal &rarr;
                </div>
            </a>

            <a href="{{ route('dashboard') }}" class="group block p-6 border-2 border-slate-200 rounded-xl hover:border-slate-800 hover:bg-slate-50 transition duration-300">
                <div class="text-4xl mb-3 group-hover:scale-110 transition">👨‍💻</div>
                <h2 class="text-xl font-bold text-slate-700 mb-2">Login Admin</h2>
                <p class="text-sm text-slate-500">Kelola klien, buat invoice, dan pantau laporan keuangan.</p>
                <div class="mt-4 inline-block bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-sm font-bold group-hover:bg-slate-800 group-hover:text-white transition">
                    Masuk Dasbor &rarr;
                </div>
            </a>
        </div>
    </div>

</body>
</html>