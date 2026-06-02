<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvoice = Invoice::count();
        $paid = Invoice::where('status', 'Paid')->count();
        
        // Unpaid = Tagihan yang sudah sah tapi belum lunas (Sent, Pending, Overdue)
        $unpaid = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->count();
        $overdue = Invoice::where('status', 'Overdue')->count();
        
        // REKAP PIUTANG: Kalkulasi total nominal uang dari tagihan yang belum dibayar
        $totalPiutang = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->sum('total');

        $invoices = Invoice::with('klien')->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('totalInvoice', 'paid', 'unpaid', 'overdue', 'totalPiutang', 'invoices'));
    }

    public function laporan()
    {
        $totalInvoice = Invoice::count();
        $paid = Invoice::where('status', 'Paid')->count();
        $unpaid = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->count();
        $overdue = Invoice::where('status', 'Overdue')->count();
        
        $totalPiutang = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->sum('total');

        return view('laporan', compact('totalInvoice', 'paid', 'unpaid', 'overdue', 'totalPiutang'));
    }
}