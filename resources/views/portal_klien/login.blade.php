<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Login Pelanggan - InvoPay</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
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
<body class="bg-[#f4f7fe] flex items-center justify-center h-screen relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-[400px] bg-[#0b132b] rounded-b-[100px] shadow-lg"></div>

    <div class="relative z-10 bg-white p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md border border-gray-100 mx-4 animate-entrance" style="animation-delay: 0.1s;">
        
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-tie text-[40px] text-[#5b80ff]"></i>
                </div>
            </div>
            <h1 class="text-2xl font-extrabold text-[#1b254b] mb-2">Portal Pelanggan</h1>
            <p class="text-gray-500 text-sm font-medium px-2">Masukkan email perusahaan/klien Anda untuk mengecek dan membayar tagihan.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-6 text-sm font-bold text-center border border-red-100 flex items-center justify-center animate-entrance" style="animation-delay: 0.2s;">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('portal.auth') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-[#1b254b] font-bold mb-2 text-sm">Email Terdaftar</label>
                <input type="email" name="email" class="w-full border-2 border-gray-200 p-3.5 rounded-xl focus:outline-none focus:border-[#5b80ff] focus:ring-4 focus:ring-blue-500/10 bg-gray-50 transition font-medium text-[#1b254b]" placeholder="contoh@perusahaan.com" required>
            </div>
            
            <button type="submit" class="w-full bg-[#5b80ff] hover:bg-blue-600 text-white font-extrabold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-blue-500/30 transition duration-300 transform hover:-translate-y-1">
                Masuk ke Portal
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('welcome') }}" class="text-sm text-gray-400 hover:text-[#5b80ff] font-bold transition flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>