<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvoPay Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f7fe] flex h-screen overflow-hidden">

    <div class="w-[260px] bg-[#0b132b] text-white flex flex-col justify-between z-20">
        <div>
            <div class="px-8 py-8 text-2xl font-bold flex items-center tracking-wide">
                <i class="fas fa-file-invoice text-[#5b80ff] mr-3"></i> 
                <span class="text-white">Invo</span><span class="text-[#5b80ff]">Pay</span>
            </div>
            
            <nav class="px-6 space-y-2 mt-4">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('/') || request()->is('dashboard') ? 'bg-[#5b80ff] text-white font-semibold' : 'text-gray-400 hover:text-white font-medium' }}">
                    <i class="fas fa-chart-line w-7 text-lg"></i> Dashboard
                </a>
                
                <a href="{{ route('klien.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('klien*') ? 'bg-[#5b80ff] text-white font-semibold' : 'text-gray-400 hover:text-white font-medium' }}">
                    <i class="fas fa-users w-7 text-lg"></i> Kelola Klien
                </a>
                
                <a href="{{ route('produk.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('produk*') ? 'bg-[#5b80ff] text-white font-semibold' : 'text-gray-400 hover:text-white font-medium' }}">
                    <i class="fas fa-box w-7 text-lg"></i> Kelola Produk
                </a>

                <a href="{{ route('invoice.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('invoice*') ? 'bg-[#5b80ff] text-white font-semibold' : 'text-gray-400 hover:text-white font-medium' }}">
                    <i class="fas fa-file-invoice-dollar w-7 text-lg"></i> Kelola Invoice
                </a>
                
                <a href="{{ route('pembayaran.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('pembayaran*') ? 'bg-[#5b80ff] text-white font-semibold' : 'text-gray-400 hover:text-white font-medium' }}">
                    <i class="fas fa-credit-card w-7 text-lg"></i> Pembayaran
                </a>
                
                <a href="{{ route('laporan.index') }}" class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->is('laporan*') ? 'bg-[#5b80ff] text-white font-semibold' : 'text-gray-400 hover:text-white font-medium' }}">
                    <i class="fas fa-chart-pie w-7 text-lg"></i> Laporan
                </a>
            </nav>
        </div>
        
        <div class="p-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-3.5 text-gray-400 hover:text-white bg-[#1a2238] rounded-xl w-full text-sm font-semibold transition-all">
                    <i class="fas fa-sign-out-alt w-7 text-lg"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <header class="pt-8 px-10 pb-2 flex justify-between items-center z-50 relative">
            <h1 class="text-3xl font-extrabold text-[#1b254b]">Dashboard</h1>
            
            <div class="relative">
                <button id="profileButton" class="flex items-center gap-3 bg-white px-4 py-2 rounded-full shadow-sm hover:shadow-md transition-all focus:outline-none focus:ring-2 focus:ring-[#5b80ff]/50 cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_admin ?? 'Admin InvoPay') }}&background=0b132b&color=fff&rounded=true" alt="Avatar" class="w-8 h-8 rounded-full">
                    <span class="font-bold text-sm text-[#1b254b]">{{ Auth::user()->nama_admin ?? 'Admin InvoPay' }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-400 ml-1"></i>
                </button>

                <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-lg border border-gray-100 py-2 z-50">
                    
                    <div class="px-5 py-3 border-b border-gray-50 mb-2">
                        <p class="text-xs text-gray-400 font-medium">Login sebagai</p>
                        <p class="text-sm font-bold text-[#1b254b] truncate">{{ Auth::user()->email ?? 'admin@invopay.com' }}</p>
                    </div>
                    
                    <a href="{{ route('profile.index') }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-[#f4f7fe] hover:text-[#5b80ff] transition-colors">
                        <i class="fas fa-user-cog w-5 text-center mr-2"></i> Pengaturan Akun
                    </a>
                    
                    <div class="border-t border-gray-50 mt-2 pt-2">
                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-5 text-center mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-10 pb-10 pt-4">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileButton = document.getElementById('profileButton');
            const profileDropdown = document.getElementById('profileDropdown');

            // Fungsi Toggle saat tombol diklik
            profileButton.addEventListener('click', function(event) {
                event.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            // Tutup dropdown jika user klik di sembarang tempat (di luar menu)
            window.addEventListener('click', function(event) {
                if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>