<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $payments = Pembayaran::with('invoice.klien')->get(); 
        return view('pembayaran', compact('payments'));
    }
}