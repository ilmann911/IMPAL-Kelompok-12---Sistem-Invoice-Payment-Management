<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>InvoPay - Portal Pelanggan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <nav class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span class="text-4xl">🏢</span>
                <div>
                    <h1 class="font-extrabold text-2xl text-white tracking-wide">Portal Pelanggan</h1>
                    <p class="text-blue-100 text-sm font-medium">{{ session('nama_klien') }}</p>
                </div>
            </div>
            <a href="{{ route('portal.logout') }}" class="flex items-center space-x-2 bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl transition duration-300 backdrop-blur-sm font-bold shadow-sm">
                <span>🚪</span>
                <span>Keluar Portal</span>
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-10 w-full flex-grow">
        
        <div class="mb-8">
            <h2 class="text-4xl font-extrabold text-slate-800 mb-2">Tagihan Anda</h2>
            <p class="text-slate-500 text-lg">Kelola, pantau, dan bayar seluruh invoice perusahaan Anda di satu tempat yang terintegrasi.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-8 border-green-500 text-green-800 p-5 rounded-r-xl mb-8 shadow-sm flex items-center text-lg">
                <span class="text-3xl mr-4">🎉</span>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="p-6 text-sm font-extrabold text-slate-500 uppercase tracking-widest">No. Invoice</th>
                            <th class="p-6 text-sm font-extrabold text-slate-500 uppercase tracking-widest">Jatuh Tempo</th>
                            <th class="p-6 text-sm font-extrabold text-slate-500 uppercase tracking-widest">Total Tagihan</th>
                            <th class="p-6 text-sm font-extrabold text-slate-500 uppercase tracking-widest text-center">Status</th>
                            <th class="p-6 text-sm font-extrabold text-slate-500 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($invoices as $inv)
                        <tr class="hover:bg-blue-50/50 transition duration-300">
                            <td class="p-6">
                                <div class="font-extrabold text-2xl text-blue-600">{{ $inv->no_invoice }}</div>
                            </td>
                            
                            <td class="p-6">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xl">🗓️</span>
                                    <span class="text-lg font-semibold text-slate-600">
                                        {{ \Carbon\Carbon::parse($inv->tanggal_jatuh_tempo)->format('d F Y') }}
                                    </span>
                                </div>
                            </td>

                            <td class="p-6">
                                <div class="font-extrabold text-2xl text-slate-800">Rp {{ number_format($inv->total, 0, ',', '.') }}</div>
                            </td>

                            <td class="p-6 text-center">
                                <span class="inline-block px-5 py-2 rounded-full text-sm font-extrabold tracking-wider shadow-sm
                                    {{ $inv->status == 'Paid' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                    {{ $inv->status == 'Sent' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                                    {{ $inv->status == 'Draft' ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' }}
                                    {{ $inv->status == 'Overdue' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}
                                ">
                                    {{ strtoupper($inv->status) }}
                                </span>
                            </td>

                            <td class="p-6">
                                <div class="flex justify-center space-x-3">
                                    <a href="{{ route('portal.invoice.pdf', $inv->id_invoice) }}" class="flex items-center px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-bold transition duration-200 border border-slate-200">
                                        <span class="mr-2 text-lg">📄</span> PDF
                                    </a>
                                    
                                    @if($inv->status != 'Paid')
                                        <a href="{{ route('pembayaran.create', $inv->id_invoice) }}" class="flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg hover:shadow-blue-500/50 transition-all duration-300 transform hover:-translate-y-1">
                                            <span class="mr-2 text-lg">💳</span> Bayar Sekarang
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="text-7xl mb-6">📭</div>
                                <h3 class="text-3xl font-extrabold text-slate-700 mb-3">Belum Ada Tagihan</h3>
                                <p class="text-slate-500 text-xl">Perusahaan Anda saat ini tidak memiliki invoice yang perlu dibayar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center py-6 text-slate-400 font-medium mt-auto">
        &copy; 2026 Sistem Invoice & Payment Management - Telkom University
    </footer>

</body>
</html>