<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use Carbon\Carbon;

class PengecekanInvoice extends Command
{
    protected $signature = 'invoice:cek-jatuh-tempo';

    protected $description = 'Mengecek tanggal jatuh tempo dan mengubah status menjadi Overdue';

    public function handle()
    {
        $hariIni = Carbon::today();


        $jumlahDiupdate = Invoice::where('status', 'Sent')
               ->whereDate('tanggal_jatuh_tempo', '<', $hariIni)
               ->update(['status' => 'Overdue']);

        $this->info("Pengecekan selesai. {$jumlahDiupdate} invoice berhasil diubah menjadi Overdue.");
    }
}