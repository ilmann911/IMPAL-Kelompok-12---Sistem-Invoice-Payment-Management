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
        DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending'])
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        $totalInvoice = DB::table('tb_invoice')->count();
        $paid = DB::table('tb_invoice')->where('status', 'Paid')->count();
        
        $unpaid = DB::table('tb_invoice')->whereIn('status', ['Sent', 'Pending', 'Overdue'])->count(); 
        $overdue = DB::table('tb_invoice')->where('status', 'Overdue')->count();

        $totalPendapatan = DB::table('tb_invoice')
            ->where('status', 'Paid')
            ->sum('total');

        $totalPiutang = DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending', 'Overdue'])
            ->sum('total');

        $totalOverdueNominal = DB::table('tb_invoice')
            ->where('status', 'Overdue')
            ->sum('total');

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

        return view('laporan', compact(
            'totalInvoice', 'paid', 'unpaid', 'overdue', 
            'totalPendapatan', 'totalPiutang', 'totalOverdueNominal', 'totalKeseluruhan', 
            'topKliens', 'recentInvoices'
        ));
    }

    public function exportPdf()
    {
        DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending'])
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        $totalInvoice = DB::table('tb_invoice')->count();
        $paid = DB::table('tb_invoice')->where('status', 'Paid')->count();
        $unpaid = DB::table('tb_invoice')->whereIn('status', ['Sent', 'Pending', 'Overdue'])->count(); 
        $overdue = DB::table('tb_invoice')->where('status', 'Overdue')->count();

        $totalOutstanding = DB::table('tb_invoice')
            ->whereIn('status', ['Sent', 'Pending', 'Overdue'])
            ->sum('total');

        $totalPendapatan = DB::table('tb_invoice')->where('status', 'Paid')->sum('total');

        $totalOverdueNominal = DB::table('tb_invoice')->where('status', 'Overdue')->sum('total');

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