<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Pelanggan - InvoPay</title>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-1/2 bg-blue-600 rounded-b-full opacity-10"></div>

    <div class="relative z-10 bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-slate-100">
        <div class="text-center mb-6">
            <div class="text-5xl mb-2">🧑‍💼</div>
            <h1 class="text-2xl font-bold text-blue-600 mb-1">Portal Pelanggan</h1>
            <p class="text-slate-500 text-sm">Masukkan email perusahaan/klien Anda untuk mengecek dan membayar tagihan.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm font-semibold text-center border border-red-200">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('portal.auth') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-slate-700 font-bold mb-2">Email Terdaftar</label>
                <input type="email" name="email" class="w-full border-2 border-slate-200 p-3 rounded-lg focus:outline-none focus:border-blue-500 bg-slate-50 transition" placeholder="contoh@perusahaan.com" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-200">
                Masuk ke Portal
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('welcome') }}" class="text-sm text-slate-400 hover:text-blue-500 font-semibold transition">&larr; Kembali ke Halaman Utama</a>
        </div>
    </div>

</body>
</html>