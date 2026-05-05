<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Menghitung jumlah masing-masing status invoice
        $totalInvoice = DB::table('tb_invoice')->count();
        $paid = DB::table('tb_invoice')->where('status', 'Paid')->count();
        $unpaid = DB::table('tb_invoice')->whereIn('status', ['Draft', 'Sent', 'Pending'])->count(); // Tambahkan 'Pending' ke hitungan Unpaid
        $overdue = DB::table('tb_invoice')->where('status', 'Overdue')->count();

        // 2. Menghitung total uang masuk (Hanya yang statusnya Paid)
        $totalPendapatan = DB::table('tb_invoice')
            ->where('status', 'Paid')
            ->sum('total');

        // 3. Ambil invoice yang HANYA berstatus PAID
        // Diurutkan berdasarkan updated_at agar yang baru lunas langsung muncul di paling atas
        $recentInvoices = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.status', 'Paid') // Tambahkan baris ini untuk memfilter data
            ->select('tb_invoice.*', 'tb_klien.nama_klien')
            ->orderBy('tb_invoice.updated_at', 'desc')
            ->get();

        // 4. Kirim semua data ke view
        return view('laporan', compact('totalInvoice', 'paid', 'unpaid', 'overdue', 'totalPendapatan', 'recentInvoices'));
    }
}