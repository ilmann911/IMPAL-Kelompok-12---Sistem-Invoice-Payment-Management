<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon; // Wajib dipanggil untuk Silent Trigger

class LaporanController extends Controller
{
    public function index()
    {
        // 0. SILENT TRIGGER: Update otomatis sebelum data dihitung
        DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending'])
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        // 1. Menghitung jumlah masing-masing status invoice
        $totalInvoice = DB::table('tb_invoice')->count();
        $paid = DB::table('tb_invoice')->where('status', 'Paid')->count();
        
        // Merapikan status belum lunas (hilangkan Draft, tambahkan Overdue agar sinkron)
        $unpaid = DB::table('tb_invoice')->whereIn('status', ['Sent', 'Pending', 'Overdue'])->count(); 
        $overdue = DB::table('tb_invoice')->where('status', 'Overdue')->count();

        // 2. Menghitung total uang masuk (Pendapatan Lunas)
        $totalPendapatan = DB::table('tb_invoice')
            ->where('status', 'Paid')
            ->sum('total');

        // 3. REKAP PIUTANG: Menghitung total nominal tagihan yang belum lunas
        $totalPiutang = DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending', 'Overdue'])
            ->sum('total');

        // 3.1 PIUTANG MACET: Khusus nominal tagihan yang sudah lewat tenggat
        $totalOverdueNominal = DB::table('tb_invoice')
            ->where('status', 'Overdue')
            ->sum('total');

        // 3.5 GRAND TOTAL: Keseluruhan uang (Lunas + Belum Lunas) - Mengabaikan Draft
        $totalKeseluruhan = DB::table('tb_invoice')
            ->whereIn('status', ['Paid', 'Sent', 'Pending', 'Overdue'])
            ->sum('total');

        // 4. Ambil data Top 3 Klien
        $topKliens = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.status', 'Paid')
            ->select('tb_klien.nama_klien', DB::raw('SUM(tb_invoice.total) as total'))
            ->groupBy('tb_klien.id_klien', 'tb_klien.nama_klien')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        // 5. Ambil invoice Paid
        $recentInvoices = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.status', 'Paid') 
            ->select('tb_invoice.*', 'tb_klien.nama_klien')
            ->orderBy('tb_invoice.updated_at', 'desc')
            ->get();

        return view('laporan', compact(
            'totalInvoice', 'paid', 'unpaid', 'overdue', 
            'totalPendapatan', 'totalPiutang', 'totalOverdueNominal', 'totalKeseluruhan', 
            'topKliens', 'recentInvoices'
        ));
    }

    public function exportPdf()
    {
        // 0. SILENT TRIGGER: Update otomatis sebelum PDF dibuat
        DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending'])
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        // 1. Data Ringkasan
        $totalInvoice = DB::table('tb_invoice')->count();
        $paid = DB::table('tb_invoice')->where('status', 'Paid')->count();
        $unpaid = DB::table('tb_invoice')->whereIn('status', ['Sent', 'Pending', 'Overdue'])->count(); 
        $overdue = DB::table('tb_invoice')->where('status', 'Overdue')->count();

        // 2. Tambahan data untuk PDF (Outstanding & Aging)
        $totalOutstanding = DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending', 'Overdue'])
            ->sum('total');

        $totalPendapatan = DB::table('tb_invoice')->where('status', 'Paid')->sum('total');

        $totalOverdueNominal = DB::table('tb_invoice')->where('status', 'Overdue')->sum('total');

        // Grand Total untuk PDF
        $totalKeseluruhan = DB::table('tb_invoice')
            ->whereIn('status', ['Paid', 'Sent', 'Pending', 'Overdue'])
            ->sum('total');

        $topKliens = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.status', 'Paid')
            ->select('tb_klien.nama_klien', DB::raw('SUM(tb_invoice.total) as total'))
            ->groupBy('tb_klien.id_klien', 'tb_klien.nama_klien')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $recentInvoices = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.status', 'Paid')
            ->select('tb_invoice.*', 'tb_klien.nama_klien')
            ->orderBy('tb_invoice.updated_at', 'desc')
            ->get();

        // Aging Report (Invoice Overdue + Hitung Hari)
        $overdueInvoices = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.status', 'Overdue')
            ->select(
                'tb_invoice.no_invoice', 
                'tb_klien.nama_klien', 
                'tb_invoice.tanggal_jatuh_tempo as due_date',
                DB::raw('DATEDIFF(CURRENT_DATE, tb_invoice.tanggal_jatuh_tempo) as days_late')
            )
            ->get();

        // Tembak semua data ke file view PDF
        $pdf = Pdf::loadView('laporan_pdf', compact(
            'totalInvoice', 'paid', 'unpaid', 'overdue', 
            'totalPendapatan', 'totalOutstanding', 'totalOverdueNominal', 'totalKeseluruhan', 
            'topKliens', 'recentInvoices', 'overdueInvoices'
        ));
        
        $pdf->setPaper('A4', 'portrait');

        $timestamp = now()->setTimezone('Asia/Jakarta')->format('Y-m-d_H.i.s');
        return $pdf->download('LaporanKeuanganInvoPay_' . $timestamp . '.pdf');
    }
}