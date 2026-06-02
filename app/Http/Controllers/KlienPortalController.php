<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Tambahan wajib untuk manipulasi tanggal dan waktu
use Barryvdh\DomPDF\Facade\Pdf; // Tambahan wajib untuk fitur PDF

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
            ->where('status', '!=', 'Draft') // BARIS INI MENYEMBUNYIKAN DRAFT DARI KLIEN
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
                
                // Pastikan kolom tanggal_jatuh_tempo ada nilainya agar tidak error
                if ($inv->tanggal_jatuh_tempo) {
                    $tglJatuhTempo = Carbon::parse($inv->tanggal_jatuh_tempo);
                    $selisihHari = $hariIni->diffInDays($tglJatuhTempo, false); // Minus jika lewat tempo

                    // Jika sudah telat (minus) atau statusnya terlanjur Overdue
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
        // ========================================================
            
        // Melempar data invoices, notifikasi, dan jumlahnya ke view blade
        return view('portal_klien.dashboard', compact('invoices', 'notifikasi', 'jumlahNotif'));
    }

    public function downloadPdf($id) {
        // 1. Validasi Keamanan: Pastikan yang mengakses adalah klien pemilik tagihan
        if (!session('id_klien')) return redirect()->route('portal.login');

        // 2. Tarik data utama Invoice beserta Klien yang berelasi
        $invoice = DB::table('tb_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->where('tb_invoice.id_invoice', $id)
            ->where('tb_invoice.id_klien', session('id_klien')) // Keamanan ekstra
            ->first();

        // Cegah error jika ID invoice diubah sembarangan di URL
        if (!$invoice) {
            return back()->with('error', 'Dokumen Invoice tidak ditemukan atau akses ditolak.');
        }

        // 3. Tarik data Item Produk yang dibeli di dalam invoice tersebut
        $details = DB::table('tb_invoice_detail')
            ->join('tb_produk', 'tb_invoice_detail.id_produk', '=', 'tb_produk.id_produk')
            ->where('tb_invoice_detail.id_invoice', $id)
            ->get();

        // 4. Render tampilan ke PDF
        $pdf = Pdf::loadView('portal_klien.invoice_pdf', compact('invoice', 'details'));
        
        // 5. Unduh otomatis dengan penamaan file yang rapi
        return $pdf->download('INVOICE_' . $invoice->no_invoice . '.pdf');
    }

    public function logout() {
        session()->forget(['id_klien', 'nama_klien']);
        return redirect()->route('portal.login');
    }
}