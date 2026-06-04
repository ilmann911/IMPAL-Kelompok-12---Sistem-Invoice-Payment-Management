<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Klien;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Artisan; 
use Carbon\Carbon; // Tambahan wajib untuk manipulasi tanggal otomatis

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // 1. SILENT TRIGGER: Update otomatis ketika admin membuka halaman Kelola Invoice
        Invoice::whereIn('status', ['Sent', 'Pending'])
               ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
               ->update(['status' => 'Overdue']);

        // 2. Ambil kata kunci pencarian dari URL (jika ada)
        $search = $request->input('search');

        // 3. Siapkan query dasar
        $query = Invoice::with('klien');

        // 4. Jika ada input pencarian, filter datanya
        if ($search) {
            $query->where('no_invoice', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%")
                  ->orWhereHas('klien', function($q) use ($search) {
                      $q->where('nama_klien', 'LIKE', "%{$search}%");
                  });
        }

        // 5. Eksekusi query
        $invoices = $query->get();

        return view('invoice', compact('invoices'));
    }

    public function create()
    {
        $klien = Klien::all(); 
        $produk = Produk::all(); 
        return view('invoice.create', compact('klien', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_klien' => 'required',
            'id_produk' => 'required',
            'tanggal_buat' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $id_klien_final = $request->id_klien;
        if ($request->id_klien === 'new') {
            $request->validate([
                'nama_klien_baru' => 'required|string',
                'email_klien_baru' => 'required|email'
            ]);
            $klienBaru = Klien::create([
                'nama_klien' => $request->nama_klien_baru,
                'email_klien' => $request->email_klien_baru
            ]);
            $id_klien_final = $klienBaru->id_klien; 
        }

        $produk = Produk::findOrFail($request->id_produk);
        $total_otomatis = $produk->harga_satuan; 
        $no_invoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

        $invoice = Invoice::create([
            'no_invoice' => $no_invoice,
            'id_klien' => $id_klien_final, 
            'id_admin' => Auth::id() ?? 1,
            'tanggal_buat' => $request->tanggal_buat,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'total' => $total_otomatis,
            'status' => 'Draft' 
        ]);

        InvoiceDetail::create([
            'id_invoice' => $invoice->id_invoice, 
            'id_produk'  => $produk->id_produk,
            'quantity'   => 1,
            'harga_jual_saat_ini' => $total_otomatis,
        ]);

        return redirect()->route('invoice.index')->with('success', 'Sempurna! Invoice berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        DB::table('tb_invoice')
            ->where('id_invoice', $id)
            ->update(['status' => $request->status]);

        return redirect()->route('invoice.index')->with('success', 'Status invoice berhasil diperbarui!');
    }

    public function triggerReminder()
    {
        // Tombol ini sekarang hanya berfokus mengeksekusi pengiriman EMAIL Reminder (jika artisan mu tersetting begitu)
        Artisan::call('invoice:cek-jatuh-tempo');
        return redirect()->back()->with('success', 'Email Reminder berhasil dieksekusi secara manual!');
    }
}