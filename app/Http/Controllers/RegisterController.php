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
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:tb_admin',
            'password'   => 'required|string|min:8|confirmed', 
        ]);

        Admin::create([
            'nama_admin' => $request->nama_admin,
            'email'      => $request->email,
            'password'   => Hash::make($request->password), 
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
    }
}