<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        // ========================================================
        // SILENT TRIGGER: Update otomatis khusus invoice milik klien ini
        // ========================================================
        DB::table('tb_invoice')
            ->where('id_klien', session('id_klien'))
            ->whereIn('status', ['Sent', 'Pending'])
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->update(['status' => 'Overdue']);

        // SEKARANG ambil data yang sudah 100% akurat dan sinkron
        $invoices = DB::table('tb_invoice')
            ->where('id_klien', session('id_klien'))
            ->where('status', '!=', 'Draft')
            ->orderBy('created_at', 'desc')
            ->get();

        // ========================================================
        // LOGIKA NOTIFIKASI REMINDER INSTAN (LONCENG)
        // ========================================================
        $hariIni = Carbon::today();
        $notifikasi = [];

        foreach ($invoices as $inv) {
            // Hanya buat reminder untuk tagihan yang belum lunas
            if (in_array($inv->status, ['Sent', 'Overdue', 'Pending'])) {
                
                if ($inv->tanggal_jatuh_tempo) {
                    $tglJatuhTempo = Carbon::parse($inv->tanggal_jatuh_tempo);
                    $selisihHari = $hariIni->diffInDays($tglJatuhTempo, false);

                    // Jika sudah telat atau statusnya terlanjur Overdue
                    if ($selisihHari < 0 || $inv->status == 'Overdue') {
                        $notifikasi[] = [
                            'warna' => 'text-red-600',
                            'pesan' => "Tagihan {$inv->no_invoice} telah MELEWATI jatuh tempo! Segera lakukan pembayaran."
                        ];
                    } 
                    // Jika mendekati jatuh tempo (H-3 sampai Hari H)
                    elseif ($selisihHari <= 3 && $selisihHari >= 0) {
                        $notifikasi[] = [
                            'warna' => 'text-yellow-600',
                            'pesan' => "Pengingat: Tagihan {$inv->no_invoice} jatuh tempo dalam {$selisihHari} hari."
                        ];
                    }
                }
            }
        }

        $jumlahNotif = count($notifikasi);
            
        return view('portal_klien.dashboard', compact('invoices', 'notifikasi', 'jumlahNotif'));
    }

    public function downloadPdf($id) {
        if (!session('id_klien')) return redirect()->route('portal.login');

        $invoice = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.id_invoice', $id)
            ->where('tb_invoice.id_klien', session('id_klien'))
            ->first();

        if (!$invoice) {
            return back()->with('error', 'Dokumen Invoice tidak ditemukan atau akses ditolak.');
        }

        $details = DB::table('tb_invoice_detail')
            ->join('tb_produk', 'tb_invoice_detail.id_produk', '=', 'tb_produk.id_produk')
            ->where('tb_invoice_detail.id_invoice', $id)
            ->get();

        $pdf = Pdf::loadView('portal_klien.invoice_pdf', compact('invoice', 'details'));
        
        return $pdf->download('INVOICE_' . $invoice->no_invoice . '.pdf');
    }

    public function logout() {
        session()->forget(['id_klien', 'nama_klien']);
        return redirect()->route('portal.login');
    }
}