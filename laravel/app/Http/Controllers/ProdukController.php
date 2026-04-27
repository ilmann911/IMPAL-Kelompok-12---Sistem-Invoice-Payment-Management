<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi input disesuaikan dengan form
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0', // <-- Disesuaikan
        ]);

        // 2. Simpan ke database dengan menjabarkan kolomnya
        Produk::create([
            'kode_produk'  => 'PRD-' . rand(100, 999), // Generate kode otomatis
            'nama_produk'  => $request->nama_produk,
            'satuan'       => 'Jasa', // Nilai default
            'harga_satuan' => $request->harga_satuan, // Mengambil dari inputan form
            'stock_min'    => 1,      // Nilai default
            'stock'        => 1       // Nilai default
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk / Jasa baru berhasil ditambahkan!');
    }
}