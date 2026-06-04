<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Tambahan wajib untuk Query Top Klien

class DashboardController extends Controller
{
    public function index()
    {
        // 1. SILENT TRIGGER
        Invoice::whereIn('status', ['Sent', 'Pending'])
               ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
               ->update(['status' => 'Overdue']);

        $totalInvoice = Invoice::count();
        $paid = Invoice::where('status', 'Paid')->count();
        $unpaid = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->count();
        $overdue = Invoice::where('status', 'Overdue')->count();
        $totalPiutang = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->sum('total');

        $invoices = Invoice::with('klien')->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('totalInvoice', 'paid', 'unpaid', 'overdue', 'totalPiutang', 'invoices'));
    }

    public function laporan()
    {
        // 1. SILENT TRIGGER
        Invoice::whereIn('status', ['Sent', 'Pending'])
               ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
               ->update(['status' => 'Overdue']);

        // 2. REKAP METRIK KARTU ATAS
        $totalInvoice = Invoice::count();
        $paid = Invoice::where('status', 'Paid')->count();
        $unpaid = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->count();
        $overdue = Invoice::where('status', 'Overdue')->count();
        
        // 3. REKAP KEUANGAN (3 Kotak Utama)
        $totalPendapatan = Invoice::where('status', 'Paid')->sum('total');
        $totalPiutang = Invoice::whereIn('status', ['Sent', 'Pending', 'Overdue'])->sum('total');
        // Grand Total Keseluruhan (Lunas + Belum Lunas, mengabaikan Draft)
        $totalKeseluruhan = Invoice::whereIn('status', ['Paid', 'Sent', 'Pending', 'Overdue'])->sum('total');

        // 4. DATA TOP KLIEN (Berdasarkan total nominal lunas terbanyak)
        $topKliens = Invoice::join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->select('tb_klien.nama_klien', DB::raw('SUM(tb_invoice.total) as total'))
            ->where('tb_invoice.status', 'Paid')
            ->groupBy('tb_klien.id_klien', 'tb_klien.nama_klien')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 5. DATA RIWAYAT TRANSAKSI TERAKHIR (Khusus Lunas)
        $recentInvoices = Invoice::join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->select('tb_invoice.no_invoice', 'tb_klien.nama_klien', 'tb_invoice.status')
            ->where('tb_invoice.status', 'Paid')
            ->orderBy('tb_invoice.created_at', 'desc')
            ->take(5)
            ->get();

        // 6. LEMPAR SEMUA DATA KE VIEW LARAVEL BLADE
        return view('laporan', compact(
            'totalInvoice', 'paid', 'unpaid', 'overdue', 
            'totalPiutang', 'totalPendapatan', 'totalKeseluruhan',
            'topKliens', 'recentInvoices'
        ));
    }
}