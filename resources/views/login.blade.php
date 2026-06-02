<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Admin - InvoPay</title>
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
<body class="bg-[#f4f7fe] min-h-screen flex items-center justify-center relative overflow-hidden p-4">

    <div class="absolute top-0 left-0 w-full h-[400px] bg-[#0b132b] rounded-b-[100px] shadow-lg"></div>

    <div class="relative z-10 bg-white rounded-3xl shadow-2xl w-full max-w-4xl flex flex-col md:flex-row overflow-hidden border border-gray-100 animate-entrance" style="animation-delay: 0.1s;">
        
        <div class="hidden md:flex flex-col justify-center w-1/2 bg-[#5b80ff] p-12 text-white relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#0b132b]/10 rounded-tr-full"></div>
            
            <div class="relative z-10">
                <i class="fas fa-file-invoice text-5xl mb-6 drop-shadow-md"></i>
                <h1 class="text-4xl font-extrabold mb-2 tracking-tight">InvoPay</h1>
                <p class="text-blue-100 mb-8 font-medium text-lg">Sistem Invoice & Payment Management Terintegrasi</p>
                <ul class="space-y-4 text-sm font-medium">
                    <li class="flex items-center"><i class="fas fa-check-circle mr-3 text-white/80 text-lg"></i> Kelola Klien & Invoice</li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-3 text-white/80 text-lg"></i> Pantau Pembayaran Real-time</li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-3 text-white/80 text-lg"></i> Laporan & Rekap Otomatis</li>
                </ul>
            </div>
        </div>
        
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
            <div class="text-center mb-8">
                <div class="md:hidden flex justify-center mb-4">
                    <i class="fas fa-user-shield text-4xl text-[#0b132b]"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-[#1b254b] mb-2 tracking-tight">Welcome Back!</h2>
                <p class="text-gray-500 text-sm font-medium">Login admin untuk mengakses dashboard</p>
            </div>

            @if(session()->has('loginError'))
                <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-6 text-sm font-bold text-center border border-red-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('loginError') }} 
                </div>
            @endif

            @if(session()->has('success'))
                <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-6 text-sm font-bold text-center border border-green-100 flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }} 
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-[#1b254b] font-bold mb-2 text-sm">Email</label>
                    <input type="email" name="email" class="w-full border-2 border-gray-200 p-3.5 rounded-xl focus:outline-none focus:border-[#5b80ff] focus:ring-4 focus:ring-blue-500/10 bg-gray-50 transition font-medium text-[#1b254b]" placeholder="admin@invopay.com" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-[#1b254b] font-bold mb-2 text-sm">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full border-2 border-gray-200 p-3.5 pr-12 rounded-xl focus:outline-none focus:border-[#5b80ff] focus:ring-4 focus:ring-blue-500/10 bg-gray-50 transition font-medium text-[#1b254b]" placeholder="Masukkan password" required>
                        <button type="button" id="togglePassword" class="absolute right-4 inset-y-0 flex items-center text-gray-400 hover:text-[#5b80ff] transition focus:outline-none">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-[#0b132b] hover:bg-[#1b254b] text-white font-extrabold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-gray-500/30 transition duration-300 transform hover:-translate-y-1">
                    Login Admin
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 font-medium">Belum punya akun? <a href="{{ route('register') }}" class="text-[#5b80ff] font-bold hover:underline">Daftar sekarang</a></p>
            </div>
            
            <div class="mt-8 text-center pt-6 border-t border-gray-100">
                <a href="{{ route('welcome') }}" class="text-sm text-gray-400 hover:text-[#5b80ff] font-bold transition flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
                </a>
            </div>
            
        </div>
    </div>
    
    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleButton.addEventListener('click', function () {
            // Ubah tipe input antara 'password' dan 'text'
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ubah icon mata (fa-eye menjadi fa-eye-slash dan sebaliknya)
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
    
</body>
</html>