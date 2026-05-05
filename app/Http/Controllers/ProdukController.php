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

    public function update(Request $request, $id)
    {
        // 1. Validasi input (Sama seperti saat store)
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        // 2. Cari data produk berdasarkan ID (Panah No. 3 di Sequence Diagram)
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // 3. Update data ke database (Panah No. 4 & 5 di Sequence Diagram)
        $produk->update([
            'kode_produk'  => $request->kode_produk,
            'nama_produk'  => $request->nama_produk,
            'harga_satuan' => $request->harga_satuan,
            'stock'        => $request->stock,
        ]);

        // 4. Redirect kembali dengan notifikasi (Panah No. 7 & 8 di Sequence Diagram)
        return redirect()->route('produk.index')->with('success', 'Data Produk Berhasil Diperbarui!');
    }
}