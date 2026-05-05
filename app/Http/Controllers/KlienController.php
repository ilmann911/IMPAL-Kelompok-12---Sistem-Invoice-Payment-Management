<?php

namespace App\Http\Controllers;

use App\Models\Klien;
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
        $request->validate([
            'nama_klien' => 'required|string|max:255',
            'email_klien' => 'required|email|unique:tb_klien,email_klien',
        ]);

        Klien::create($request->all());

        return redirect()->route('klien.index')->with('success', 'Klien baru berhasil ditambahkan!');
    }
}