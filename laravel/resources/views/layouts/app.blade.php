<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvoPay Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-400 font-sans flex h-screen overflow-hidden">

    <div class="w-64 bg-slate-900 text-white flex flex-col justify-between">
        <div>
            <div class="p-6 bg-white text-blue-600 font-bold text-2xl flex items-center">
                <span class="mr-2">📄</span> InvoPay
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard') }}" class="block px-6 py-3 {{ request()->is('/') ? 'bg-blue-600 text-white' : 'text-slate-300' }} hover:bg-slate-800">Dashboard</a>
                <a href="{{ route('invoice.index') }}" class="block px-6 py-3 {{ request()->is('invoice*') ? 'bg-blue-600 text-white' : 'text-slate-300' }} hover:bg-slate-800">Kelola Invoice</a>
                <a href="{{ route('pembayaran.index') }}" class="block px-6 py-3 {{ request()->is('pembayaran*') ? 'bg-blue-600 text-white' : 'text-slate-300' }} hover:bg-slate-800">Pembayaran</a>
                <a href="{{ route('laporan.index') }}" class="block px-6 py-3 {{ request()->is('laporan*') ? 'bg-blue-600 text-white' : 'text-slate-300' }} hover:bg-slate-800">Laporan</a>
            </nav>
        </div>
        <div class="p-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-white flex items-center">
                    <span class="mr-2">🚪</span> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="bg-white p-4 shadow flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <div class="flex items-center text-slate-600">
                <span class="font-semibold">Admin InvoPay</span>
            </div>
        </header>

        <main class="p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>