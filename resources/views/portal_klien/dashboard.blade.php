<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>InvoPay - Portal Pelanggan</title>
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

    <nav class="bg-[#0b132b] p-5 shadow-lg relative z-50">
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
            
            <div class="flex items-center space-x-6">
                
                <div class="relative inline-block text-left group">
                    <button class="relative p-2 text-white/80 hover:text-white focus:outline-none transition-colors">
                        <i class="fas fa-bell text-2xl"></i>
                        
                        @if($jumlahNotif > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-[#0b132b] rounded-full shadow-md animate-pulse">
                            {{ $jumlahNotif }}
                        </span>
                        @endif
                    </button>

                    <div class="absolute right-0 w-80 mt-2 origin-top-right bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] ring-1 ring-black ring-opacity-5 hidden group-hover:block transition-all transform opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 duration-200">
                        <div class="py-2">
                            <div class="px-5 py-3 font-extrabold text-[#1b254b] border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                                <span class="text-base">Notifikasi Anda</span>
                                @if($jumlahNotif > 0)
                                    <span class="bg-red-100 text-red-600 text-[10px] uppercase tracking-wider py-1 px-2 rounded-lg">{{ $jumlahNotif }} Baru</span>
                                @endif
                            </div>
                            
                            <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                                @forelse($notifikasi as $notif)
                                    <div class="px-5 py-4 hover:bg-blue-50/30 transition duration-200 cursor-default">
                                        <div class="flex items-start">
                                            <span class="text-xl mr-3 mt-0.5">
                                                {!! strpos($notif['warna'], 'red') !== false ? '<i class="fas fa-exclamation-circle text-red-500"></i>' : '<i class="fas fa-exclamation-triangle text-yellow-500"></i>' !!}
                                            </span>
                                            <p class="text-sm font-semibold {{ $notif['warna'] }} leading-relaxed">
                                                {{ $notif['pesan'] }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-5 py-8 text-center text-gray-400 flex flex-col items-center">
                                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-check text-2xl text-gray-300"></i>
                                        </div>
                                        <span class="font-medium text-sm">Hore! Tidak ada tagihan menunggak.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('portal.logout') }}" class="flex items-center space-x-2 bg-white/10 hover:bg-red-500/20 text-white hover:text-red-400 px-5 py-2.5 rounded-xl transition duration-300 font-bold border border-white/5 hover:border-red-500/30">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar Portal</span>
                </a>
            </div>
            </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-10 w-full flex-grow">
        
        <div class="mb-8 animate-entrance" style="animation-delay: 0.1s;">
            <h2 class="text-4xl font-extrabold text-[#1b254b] mb-2">Tagihan Anda</h2>
            <p class="text-gray-500 text-lg font-medium">Kelola, pantau, dan bayar seluruh invoice perusahaan Anda di satu tempat yang terintegrasi.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-5 rounded-2xl mb-8 shadow-sm flex items-center text-lg font-bold animate-entrance" style="animation-delay: 0.2s;">
                <i class="fas fa-check-circle text-2xl mr-3 text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-[0_4px_15px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden animate-entrance" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto p-2">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-50">
                            <th class="p-6 text-xs font-extrabold text-gray-400 uppercase tracking-widest">No. Invoice</th>
                            <th class="p-6 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Jatuh Tempo</th>
                            <th class="p-6 text-xs font-extrabold text-gray-400 uppercase tracking-widest">Total Tagihan</th>
                            <th class="p-6 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="p-6 text-xs font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($invoices as $inv)
                        <tr class="hover:bg-blue-50/30 transition duration-300">
                            <td class="p-6">
                                <div class="font-extrabold text-xl text-[#5b80ff]">{{ $inv->no_invoice }}</div>
                            </td>
                            
                            <td class="p-6">
                                <div class="flex items-center space-x-2">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                    <span class="text-[15px] font-semibold text-gray-600">
                                        {{ \Carbon\Carbon::parse($inv->tanggal_jatuh_tempo)->format('d F Y') }}
                                    </span>
                                </div>
                            </td>

                            <td class="p-6">
                                <div class="font-extrabold text-xl text-[#1b254b]">Rp {{ number_format($inv->total, 0, ',', '.') }}</div>
                            </td>

                            <td class="p-6 text-center">
                                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-extrabold tracking-wide
                                    {{ $inv->status == 'Paid' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $inv->status == 'Pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $inv->status == 'Sent' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $inv->status == 'Overdue' ? 'bg-red-100 text-red-700' : '' }}
                                ">
                                    {{ strtoupper($inv->status == 'Sent' ? 'Unpaid' : $inv->status) }}
                                </span>
                            </td>

                            <td class="p-6">
                                <div class="flex justify-center items-center space-x-3">
                                    <a href="{{ route('portal.invoice.pdf', $inv->id_invoice) }}" class="flex items-center px-4 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-xl text-sm font-bold transition duration-200 border border-gray-200">
                                        <i class="far fa-file-pdf mr-2 text-gray-400"></i> PDF
                                    </a>
                                    
                                    @if($inv->status == 'Pending')
                                        <button disabled class="flex items-center px-5 py-2.5 bg-gray-100 text-gray-400 rounded-xl text-sm font-bold border border-gray-200 cursor-not-allowed">
                                            <i class="fas fa-hourglass-half mr-2"></i> Menunggu
                                        </button>
                                    @elseif($inv->status != 'Paid')
                                        <a href="{{ route('pembayaran.create', $inv->id_invoice) }}" class="flex items-center px-5 py-2.5 bg-[#5b80ff] hover:bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                                            <i class="fas fa-credit-card mr-2"></i> Bayar
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="flex justify-center mb-4">
                                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                    </div>
                                </div>
                                <h3 class="text-2xl font-extrabold text-[#1b254b] mb-2">Belum Ada Tagihan</h3>
                                <p class="text-gray-500 text-base font-medium">Perusahaan Anda saat ini tidak memiliki invoice yang perlu dibayar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>