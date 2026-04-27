@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kelola Klien</h2>
    <a href="{{ route('klien.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
        Tambah Klien
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm border border-green-300">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded shadow p-4">
    <table class="w-full text-left">
        <tr class="bg-slate-100 border-b text-sm font-bold text-slate-600 uppercase">
            <th class="p-3">ID</th>
            <th class="p-3">Nama Klien</th>
            <th class="p-3">Email Klien</th>
            <th class="p-3">Aksi</th>
        </tr>
        @foreach($kliens as $k)
        <tr class="border-b hover:bg-gray-50">
            <td class="p-3 text-gray-500">#{{ $k->id_klien }}</td>
            <td class="p-3 font-semibold">{{ $k->nama_klien }}</td>
            <td class="p-3">{{ $k->email_klien }}</td>
            <td class="p-3">
                <button class="text-blue-500 hover:underline mr-2 text-sm">Edit</button>
                <button class="text-red-500 hover:underline text-sm">Hapus</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection