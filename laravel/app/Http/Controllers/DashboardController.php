<?php

namespace App\Http\Controllers;

use App\Models\Invoice; // Pastikan Model Invoice dipanggil
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvoice = Invoice::count();
        $paid = Invoice::where('status', 'Paid')->count();
        $unpaid = Invoice::whereIn('status', ['Draft', 'Sent'])->count();
        $overdue = Invoice::where('status', 'Overdue')->count();
        $invoices = Invoice::with('klien')->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('totalInvoice', 'paid', 'unpaid', 'overdue', 'invoices'));
    }

    public function laporan()
    {
        $totalInvoice = Invoice::count();
        $paid = Invoice::where('status', 'Paid')->count();
        $unpaid = Invoice::whereIn('status', ['Draft', 'Sent'])->count();
        $overdue = Invoice::where('status', 'Overdue')->count();

        return view('laporan', compact('totalInvoice', 'paid', 'unpaid', 'overdue'));
    }
}