<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = DB::table('tb_pembayaran')
            ->join('tb_invoice', 'tb_pembayaran.id_invoice', '=', 'tb_invoice.id_invoice')
            ->join('tb_klien', 'tb_invoice.id_klien', '=', 'tb_klien.id_klien')
            ->select('tb_pembayaran.*', 'tb_invoice.no_invoice', 'tb_invoice.total', 'tb_invoice.status', 'tb_klien.nama_klien')
            ->get();

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create($id_invoice)
    {
        $invoice = DB::table('tb_invoice')->where('id_invoice', $id_invoice)->first();
        
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice tidak ditemukan.');
        }

        return view('pembayaran.create', compact('invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_invoice' => 'required',
            'metode_pembayaran' => 'required',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $nama_file = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/bukti'), $nama_file);
        }

        $invoice = DB::table('tb_invoice')->where('id_invoice', $request->id_invoice)->first();

        $metodeEnum = 'Transfer Bank';
        if ($request->metode_pembayaran == 'QRIS') {
            $metodeEnum = 'QRIS';
        }

        DB::table('tb_pembayaran')->insert([
            'id_invoice' => $request->id_invoice,
            'id_admin' => $invoice->id_admin,
            'tanggal_bayar' => now()->toDateString(),
            'jumlah_bayar' => $invoice->total,
            'metode_bayar' => $metodeEnum,
            'bukti_transfer' => $nama_file,
            'status_verifikasi' => 'Pending',
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        DB::table('tb_invoice')->where('id_invoice', $request->id_invoice)->update(['status' => 'Pending']);

        return redirect()->route('portal.dashboard')->with('success', 'Bukti terkirim! Menunggu verifikasi Admin.');
    }

    public function verify($id_pembayaran)
    {
        $pembayaran = DB::table('tb_pembayaran')->where('id_pembayaran', $id_pembayaran)->first();

        if ($pembayaran) {
            DB::table('tb_invoice')->where('id_invoice', $pembayaran->id_invoice)->update(['status' => 'Paid']);
            
            DB::table('tb_pembayaran')->where('id_pembayaran', $id_pembayaran)->update(['status_verifikasi' => 'Verified']);
        }

        return redirect()->back()->with('success', 'Berhasil! Pembayaran telah diverifikasi dan status invoice menjadi Paid.');
    }
}