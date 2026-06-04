<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvoPay - Sistem Manajemen Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f7fe] flex items-center justify-center h-screen relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-[500px] bg-[#0b132b] rounded-b-[100px] shadow-lg"></div>

    <div class="relative z-10 flex flex-col items-center w-full max-w-3xl mx-4">
        
        <div class="text-center mb-10">
            <div class="flex justify-center mb-5">
                <i class="fas fa-file-invoice text-[64px] text-[#5b80ff] drop-shadow-lg"></i>
            </div>
            <h1 class="text-4xl font-extrabold mb-3 text-white tracking-wide">
                Selamat Datang di Invo<span class="text-[#5b80ff]">Pay</span>
            </h1>
            <p class="text-gray-400 text-lg font-medium">Sistem Invoice & Payment Management Terintegrasi</p>
        </div>

        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-2xl w-full border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                
                <a href="{{ route('portal.login') }}" class="group block p-6 border-2 border-gray-100 rounded-xl hover:border-[#5b80ff] hover:bg-[#f4f7fe] hover:shadow-md transition duration-300 text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-300">🧑‍💼</div>
                    <h2 class="text-xl font-bold text-[#1b254b] mb-2">Portal Pelanggan</h2>
                    <p class="text-sm text-gray-500 font-medium">Cek tagihan dan konfirmasi bukti pembayaran Anda di sini.</p>
                    
                    <div class="mt-5 inline-block bg-gray-100 text-[#1b254b] px-5 py-2.5 rounded-full text-sm font-bold group-hover:bg-[#5b80ff] group-hover:text-white transition duration-300">
                        Masuk Portal Pelanggan &rarr;
                    </div>
                </a>

                <a href="{{ route('dashboard') }}" class="group block p-6 border-2 border-gray-100 rounded-xl hover:border-[#0b132b] hover:bg-gray-50 hover:shadow-md transition duration-300 text-center">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition duration-300">👨‍💻</div>
                    <h2 class="text-xl font-bold text-[#1b254b] mb-2">Portal Admin</h2>
                    <p class="text-sm text-gray-500 font-medium">Kelola klien, buat invoice, dan pantau laporan keuangan.</p>
                    
                    <div class="mt-5 inline-block bg-gray-100 text-[#1b254b] px-5 py-2.5 rounded-full text-sm font-bold group-hover:bg-[#0b132b] group-hover:text-white transition duration-300">
                        Masuk Portal Admin &rarr;
                    </div>
                </a>
                
            </div>
        </div>
        
    </div>

</body>
</html>