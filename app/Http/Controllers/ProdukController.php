<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\InvoiceDetail; // Digunakan untuk mengecek relasi invoice
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
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:tb_produk,nama_produk',
            'harga_satuan' => 'required|numeric|min:0', 
        ], [
            'nama_produk.unique' => 'Nama Produk / Jasa ini sudah terdaftar di sistem!'
        ]);

        Produk::create([
            'kode_produk'  => 'PRD-' . rand(100, 999), 
            'nama_produk'  => $request->nama_produk,
            'satuan'       => 'Jasa', 
            'harga_satuan' => $request->harga_satuan, 
            'stock_min'    => 1,      
            'stock'        => 1       
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk / Jasa baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::find($id);
        
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan!');
        }

        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:tb_produk,nama_produk,' . $id . ',id_produk',
            'harga_satuan' => 'required|numeric|min:0',
        ], [
            'nama_produk.unique' => 'Nama Produk / Jasa ini sudah digunakan!'
        ]);

        $produk = Produk::find($id);

        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan!');
        }

        $produk->fill([
            'nama_produk'  => $request->nama_produk,
            'harga_satuan' => $request->harga_satuan,
        ]);

        if ($produk->isClean()) {
            return redirect()->route('produk.index')->with('info', 'Tidak ada perubahan data yang dilakukan.');
        }

        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Data Produk Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        
        if ($produk) {
            // Cek apakah produk ini sudah dipakai di dalam detail invoice
            $dipakaiDiInvoice = InvoiceDetail::where('id_produk', $id)->exists();
            
            if ($dipakaiDiInvoice) {
                return redirect()->route('produk.index')->with('error', 'Produk/Jasa tidak bisa dihapus karena sudah ada di dalam riwayat Invoice!');
            }

            $produk->delete();
            return redirect()->route('produk.index')->with('success', 'Produk / Jasa berhasil dihapus!');
        }

        return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan!');
    }
}