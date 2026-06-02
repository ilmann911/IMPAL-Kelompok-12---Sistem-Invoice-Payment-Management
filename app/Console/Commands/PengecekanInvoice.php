<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice; // Memanggil model Invoice kalian
use Carbon\Carbon; // Memanggil library waktu bawaan Laravel

class PengecekanInvoice extends Command
{
    // INILAH NAMA COMMAND YANG DICARI OLEH TOMBOLMU
    protected $signature = 'invoice:cek-jatuh-tempo';

    // Deskripsi singkat command
    protected $description = 'Mengecek tanggal jatuh tempo dan mengubah status menjadi Overdue';

    public function handle()
    {
        // Ambil tanggal hari ini (waktu server)
        $hariIni = Carbon::today();

        // LOGIKA INTI:
        // Cari tagihan di tb_invoice yang statusnya masih 'Sent' 
        // DAN tanggal_jatuh_tempo-nya sudah lewat dari hari ini
        $jumlahDiupdate = Invoice::where('status', 'Sent')
               ->whereDate('tanggal_jatuh_tempo', '<', $hariIni)
               ->update(['status' => 'Overdue']);

        // Memberikan pesan sukses di latar belakang
        $this->info("Pengecekan selesai. {$jumlahDiupdate} invoice berhasil diubah menjadi Overdue.");
    }
}