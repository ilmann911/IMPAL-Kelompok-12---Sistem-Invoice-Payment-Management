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
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        Invoice::whereIn('status', ['Sent', 'Pending'])
               ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
               ->update(['status' => 'Overdue']);

        $search = $request->input('search');

        $query = Invoice::with('klien');

        if ($search) {
            $query->where('no_invoice', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%")
                  ->orWhereHas('klien', function($q) use ($search) {
                      $q->where('nama_klien', 'LIKE', "%{$search}%");
                  });
        }

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
        Artisan::call('invoice:cek-jatuh-tempo');
        return redirect()->back()->with('success', 'Email Reminder berhasil dieksekusi secara manual!');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $klien = Klien::all();
        $produk = Produk::all();
        
        return view('invoice.edit', compact('invoice', 'klien', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;

        if ($invoice->status == 'Overdue' && Carbon::parse($request->tanggal_jatuh_tempo)->isFuture()) {
            $invoice->status = 'Sent';
        }

        $invoice->save();

        return redirect()->route('invoice.index')->with('success', 'Tanggal jatuh tempo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        InvoiceDetail::where('id_invoice', $id)->delete();
        
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil dihapus secara permanen!');
    }
}