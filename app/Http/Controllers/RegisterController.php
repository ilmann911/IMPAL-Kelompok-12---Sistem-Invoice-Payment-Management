<?php

namespace App\Http\Controllers;

use App\Models\Admin; // Pastikan Model Admin dipanggil
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan halaman (View)
    public function index()
    {
        return view('register');
    }

    // Memproses data
    public function store(Request $request)
    {
        // 1. Validasi inputan form
        // Syarat: Email harus unik (tidak boleh ada yang sama di tb_admin)
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:tb_admin',
            'password'   => 'required|string|min:8|confirmed', 
            // Aturan 'confirmed' mengharuskan ada input 'password_confirmation' di form
        ]);

        // 2. Simpan data ke tb_admin
        Admin::create([
            'nama_admin' => $request->nama_admin,
            'email'      => $request->email,
            // Enkripsi password menggunakan Hash bawaan Laravel
            'password'   => Hash::make($request->password), 
        ]);

        // 3. Kembalikan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
    }
}