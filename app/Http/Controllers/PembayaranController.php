<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // ========================================================
    // 1. FUNGSI ADMIN: Melihat Riwayat Pembayaran
    // ========================================================
    public function index()
    {
        // Mengambil data pembayaran dan menggabungkannya dengan tabel invoice & klien
        $pembayarans = DB::table('tb_pembayaran')
            ->join('tb_invoice', 'tb_pembayaran.id_invoice', '=', 'tb_invoice.id_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->select('tb_pembayaran.*', 'tb_invoice.no_invoice', 'tb_invoice.total', 'tb_invoice.status', 'tb_klien.nama_klien')
            ->get();

        return view('pembayaran.index', compact('pembayarans'));
    }

    // ========================================================
    // 2. FUNGSI PELANGGAN: Menampilkan Form Konfirmasi (SD 5.0)
    // ========================================================
    public function create($id_invoice)
    {
        // Mengambil data invoice spesifik untuk dibayar
        $invoice = DB::table('tb_invoice')->where('id_invoice', $id_invoice)->first();
        
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice tidak ditemukan.');
        }

        return view('pembayaran.create', compact('invoice'));
    }

    // ========================================================
    // 3. FUNGSI PELANGGAN: Memproses Pembayaran (SD 5.0)
    // ========================================================
    public function store(Request $request)
    {
        $request->validate([
            'id_invoice' => 'required',
            'metode_pembayaran' => 'required',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048' // Validasi file
        ]);

        // 1. Proses Upload File
        $nama_file = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti'), $nama_file);
        }

        // 2. Ambil data invoice untuk mendapatkan jumlah_bayar
        $invoice = DB::table('tb_invoice')->where('id_invoice', $request->id_invoice)->first();

        // 3. Sesuaikan dengan tipe ENUM di database kamu
        $metodeEnum = 'Transfer Bank'; // Default jika BCA/Mandiri
        if ($request->metode_pembayaran == 'QRIS') {
            $metodeEnum = 'QRIS';
        }

        // 4. Simpan Pembayaran (Sesuai persis dengan struktur tb_pembayaran milikmu)
        DB::table('tb_pembayaran')->insert([
            'id_invoice' => $request->id_invoice,
            'id_admin' => 1, // Wajib diisi sesuai database, kita set 1 (Sistem)
            'tanggal_bayar' => now()->toDateString(),
            'jumlah_bayar' => $invoice->total, // Wajib diisi sesuai database
            'metode_bayar' => $metodeEnum, // Nama kolom yang benar
            'bukti_transfer' => $nama_file,
            'status_verifikasi' => 'Pending', // Sesuai default database
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        // 5. Update Status Invoice (D4) menjadi PENDING (Menunggu Verifikasi Admin)
        DB::table('tb_invoice')->where('id_invoice', $request->id_invoice)->update(['status' => 'Pending']);

        // 6. Redirect 
        return redirect()->route('portal.dashboard')->with('success', 'Bukti terkirim! Menunggu verifikasi Admin.');
    }

    public function verify($id_pembayaran)
    {
        // 1. Ambil data pembayaran
        $pembayaran = DB::table('tb_pembayaran')->where('id_pembayaran', $id_pembayaran)->first();

        if ($pembayaran) {
            // 2. Update status invoice menjadi Paid
            DB::table('tb_invoice')->where('id_invoice', $pembayaran->id_invoice)->update(['status' => 'Paid']);
            
            // 3. Update status_verifikasi di tabel pembayaran menjadi Verified
            DB::table('tb_pembayaran')->where('id_pembayaran', $id_pembayaran)->update(['status_verifikasi' => 'Verified']);
        }

        return redirect()->back()->with('success', 'Hebat! Pembayaran telah diverifikasi dan status invoice menjadi Paid.');
    }
}