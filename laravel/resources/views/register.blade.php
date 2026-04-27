<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin - InvoPay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white rounded-lg shadow-xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
        
        <div class="bg-blue-600 text-white p-10 md:w-1/2 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-4">InvoPay</h1>
            <p class="text-lg mb-6">Invoice System & Payment Management</p>
            <ul class="space-y-3">
                <li class="flex items-center">✓ Kelola Invoice</li>
                <li class="flex items-center">✓ Pantau Pembayaran</li>
                <li class="flex items-center">✓ Laporan & Rekap</li>
            </ul>
        </div>

        <div class="p-10 md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Buat Akun!</h2>
            <p class="text-gray-500 mb-6 text-center">Daftarkan akun Admin baru</p>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_admin" value="{{ old('nama_admin') }}" class="w-full px-3 py-2 border rounded-lg bg-blue-50 outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg bg-blue-50 outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg bg-blue-50 outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg bg-blue-50 outline-none focus:border-blue-500" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                    Register
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Login di sini</a></p>
            </div>
        </div>

    </div>

</body>
</html>