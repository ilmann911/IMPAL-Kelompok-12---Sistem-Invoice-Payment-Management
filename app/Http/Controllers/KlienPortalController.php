<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlienPortalController extends Controller
{
    public function index() {
        return view('portal_klien.login');
    }

    public function login(Request $request) {
        $klien = DB::table('tb_klien')->where('email_klien', $request->email)->first();
        if ($klien) {
            session(['id_klien' => $klien->id_klien, 'nama_klien' => $klien->nama_klien]);
            return redirect()->route('portal.dashboard');
        }
        return back()->with('error', 'Email tidak terdaftar!');
    }

    public function dashboard() {
        if (!session('id_klien')) return redirect()->route('portal.login');
        
        $invoices = DB::table('tb_invoice')
            ->where('id_klien', session('id_klien'))
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('portal_klien.dashboard', compact('invoices'));
    }

    public function downloadPdf($id) {
        // Simulasi "Invoice PDF" sesuai DFD Level 1
        return "Fitur Cetak PDF Invoice #$id sedang diproses (Integrasi DomPDF)...";
    }

    public function logout() {
        session()->forget(['id_klien', 'nama_klien']);
        return redirect()->route('portal.login');
    }
}