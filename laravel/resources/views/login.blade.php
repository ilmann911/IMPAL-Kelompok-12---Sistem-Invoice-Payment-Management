<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login - InvoPay</title>
</head>
<body class="bg-blue-500 h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full mx-auto flex max-w-4xl overflow-hidden">
        
        <div class="hidden md:block w-1/2 bg-blue-600 p-10 text-white">
            <h1 class="text-3xl font-bold mb-4">InvoPay</h1>
            <p class="mb-4">Invoice System & Payment Management</p>
            <ul class="space-y-3 text-sm opacity-90">
                <li>✔ Kelola Invoice</li>
                <li>✔ Pantau Pembayaran</li>
                <li>✔ Laporan & Rekap</li>
            </ul>
        </div>
        
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-2xl font-bold text-center mb-2">Welcome!</h2>
            <p class="text-slate-500 text-center mb-6 text-sm">Login untuk mengakses dashboard</p>

            @if(session()->has('loginError'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-xs">
                    {{ session('loginError') }} 
                </div>
            @endif

            @if(session()->has('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm text-center border border-green-300">
                    {{ session('success') }} 
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" class="w-full border p-2 rounded focus:outline-blue-500" placeholder="admin@invopay.com" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded focus:outline-blue-500" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700">Login</button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar sekarang</a></p>
            </div>
            
        </div>
    </div>
</body>
</html>