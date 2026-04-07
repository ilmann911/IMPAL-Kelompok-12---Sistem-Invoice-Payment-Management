<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvoPaySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Admin
        DB::table('tb_admin')->insert([
            'nama_admin' => 'Admin Utama',
            'email' => 'admin@invopay.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Insert Klien
        DB::table('tb_klien')->insert([
            ['nama_klien' => 'PT Teknologi Maju', 'email_klien' => 'info@tekano.com'],
            ['nama_klien' => 'CV Sejahtera', 'email_klien' => 'kontak@sejahtera.id'],
        ]);

        // 3. Insert Invoice
        DB::table('tb_invoice')->insert([
            ['no_invoice' => 'INV-001', 'id_klien' => 1, 'id_admin' => 1, 'tanggal_buat' => '2026-04-01', 'tanggal_jatuh_tempo' => '2026-04-15', 'total' => 5000000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-002', 'id_klien' => 2, 'id_admin' => 1, 'tanggal_buat' => '2026-04-05', 'tanggal_jatuh_tempo' => '2026-04-10', 'total' => 1500000, 'status' => 'Overdue'],
            ['no_invoice' => 'INV-003', 'id_klien' => 1, 'id_admin' => 1, 'tanggal_buat' => '2026-04-07', 'tanggal_jatuh_tempo' => '2026-04-20', 'total' => 3000000, 'status' => 'Sent'],
        ]);
    }
}