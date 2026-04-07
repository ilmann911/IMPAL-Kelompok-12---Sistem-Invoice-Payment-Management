<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $payments = Pembayaran::with('invoice.klien')->get(); // Relasi antar tabel [cite: 65, 122]
        return view('pembayaran', compact('payments'));
    }
}