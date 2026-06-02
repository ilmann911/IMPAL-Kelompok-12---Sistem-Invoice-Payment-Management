<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use App\Models\Invoice; 
use Illuminate\Http\Request;

class KlienController extends Controller
{
    public function index()
    {
        $kliens = Klien::all();
        return view('klien.index', compact('kliens'));
    }

    public function create()
    {
        return view('klien.create');
    }

    public function store(Request $request)
    {
        // Menambahkan unique pada nama_klien
        $request->validate([
            'nama_klien' => 'required|string|max:255|unique:tb_klien,nama_klien',
            'email_klien' => 'required|email|unique:tb_klien,email_klien',
        ], [
            'nama_klien.unique' => 'Nama Perusahaan/Klien ini sudah terdaftar!',
            'email_klien.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.'
        ]);

        Klien::create($request->all());

        return redirect()->route('klien.index')->with('success', 'Klien baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $klien = Klien::find($id);
        
        if (!$klien) {
            return redirect()->route('klien.index')->with('error', 'Data klien tidak ditemukan!');
        }

        return view('klien.edit', compact('klien'));
    }

    public function update(Request $request, $id)
    {
        // Menambahkan unique pada nama_klien dan mengecualikan ID yang sedang diedit
        $request->validate([
            'nama_klien' => 'required|string|max:255|unique:tb_klien,nama_klien,' . $id . ',id_klien',
            'email_klien' => 'required|email|unique:tb_klien,email_klien,' . $id . ',id_klien',
        ], [
            'nama_klien.unique' => 'Nama Perusahaan/Klien ini sudah digunakan oleh klien lain!',
            'email_klien.unique' => 'Email ini sudah digunakan oleh klien lain!'
        ]);

        $klien = Klien::find($id);

        if (!$klien) {
            return redirect()->route('klien.index')->with('error', 'Data klien tidak ditemukan!');
        }

        $klien->fill([
            'nama_klien' => $request->nama_klien,
            'email_klien' => $request->email_klien,
        ]);

        if ($klien->isClean()) {
            return redirect()->route('klien.index')->with('info', 'Tidak ada perubahan data yang dilakukan.');
        }

        $klien->save();

        return redirect()->route('klien.index')->with('success', 'Data klien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $klien = Klien::find($id);
        
        if ($klien) {
            $punyaInvoice = Invoice::where('id_klien', $id)->exists();
            
            if ($punyaInvoice) {
                return redirect()->route('klien.index')->with('error', 'Klien tidak bisa dihapus karena masih memiliki riwayat Invoice!');
            }

            $klien->delete();
            return redirect()->route('klien.index')->with('success', 'Klien berhasil dihapus!');
        }

        return redirect()->route('klien.index')->with('error', 'Data klien tidak ditemukan!');
    }
}