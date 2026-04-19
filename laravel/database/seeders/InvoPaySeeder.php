<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvoPaySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_admin')->insert([
            'nama_admin' => 'Admin Utama',
            'email' => 'admin@invopay.com',
            'password' => Hash::make('admin123'),
        ]);

        DB::table('tb_klien')->insert([
            ['nama_klien' => 'PT Teknologi Maju', 'email_klien' => 'info@tekano.com'],
            ['nama_klien' => 'CV Sejahtera', 'email_klien' => 'kontak@sejahtera.id'],
            ['nama_klien' => 'PT Digital Nusantara', 'email_klien' => 'hello@digitalnusantara.co.id'],
            ['nama_klien' => 'UD Mandiri Bangun', 'email_klien' => 'mandiri.bangun@gmail.com'],
            ['nama_klien' => 'Firma Hukum & Rekan', 'email_klien' => 'legal@firma-rekan.com'],
            ['nama_klien' => 'PT Solusi Informatika', 'email_klien' => 'support@solusi-it.com'],
            ['nama_klien' => 'CV Abadi Sentosa', 'email_klien' => 'cs@abadisentosa.net'],
            ['nama_klien' => 'Toko Laris Manis', 'email_klien' => 'toko.larismanis@yahoo.com'],
            ['nama_klien' => 'PT Karya Cipta', 'email_klien' => 'karya.cipta@karyacipta.id'],
            ['nama_klien' => 'PT Global Inovasi', 'email_klien' => 'admin@globalinovasi.co.id'],
            ['nama_klien' => 'Bina Usaha Mandiri', 'email_klien' => 'bina.usaha@gmail.com'],
        ]);

        DB::table('tb_invoice')->insert([
            ['no_invoice' => 'INV-001', 'id_klien' => 1, 'id_admin' => 1, 'tanggal_buat' => '2026-04-01', 'tanggal_jatuh_tempo' => '2026-04-15', 'total' => 5000000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-002', 'id_klien' => 2, 'id_admin' => 1, 'tanggal_buat' => '2026-04-05', 'tanggal_jatuh_tempo' => '2026-04-10', 'total' => 1500000, 'status' => 'Overdue'],
            ['no_invoice' => 'INV-003', 'id_klien' => 1, 'id_admin' => 1, 'tanggal_buat' => '2026-04-07', 'tanggal_jatuh_tempo' => '2026-04-20', 'total' => 3000000, 'status' => 'Sent'],
            ['no_invoice' => 'INV-004', 'id_klien' => 3, 'id_admin' => 1, 'tanggal_buat' => '2026-04-08', 'tanggal_jatuh_tempo' => '2026-04-22', 'total' => 12500000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-005', 'id_klien' => 4, 'id_admin' => 1, 'tanggal_buat' => '2026-04-09', 'tanggal_jatuh_tempo' => '2026-04-23', 'total' => 750000, 'status' => 'Draft'],
            ['no_invoice' => 'INV-006', 'id_klien' => 5, 'id_admin' => 1, 'tanggal_buat' => '2026-04-10', 'tanggal_jatuh_tempo' => '2026-04-12', 'total' => 8400000, 'status' => 'Overdue'],
            ['no_invoice' => 'INV-007', 'id_klien' => 6, 'id_admin' => 1, 'tanggal_buat' => '2026-04-11', 'tanggal_jatuh_tempo' => '2026-04-25', 'total' => 4200000, 'status' => 'Sent'],
            ['no_invoice' => 'INV-008', 'id_klien' => 7, 'id_admin' => 1, 'tanggal_buat' => '2026-04-12', 'tanggal_jatuh_tempo' => '2026-04-26', 'total' => 1500000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-009', 'id_klien' => 8, 'id_admin' => 1, 'tanggal_buat' => '2026-04-13', 'tanggal_jatuh_tempo' => '2026-04-27', 'total' => 900000, 'status' => 'Draft'],
            ['no_invoice' => 'INV-010', 'id_klien' => 9, 'id_admin' => 1, 'tanggal_buat' => '2026-04-14', 'tanggal_jatuh_tempo' => '2026-04-28', 'total' => 6700000, 'status' => 'Sent'],
            ['no_invoice' => 'INV-011', 'id_klien' => 10, 'id_admin' => 1, 'tanggal_buat' => '2026-04-14', 'tanggal_jatuh_tempo' => '2026-04-21', 'total' => 2100000, 'status' => 'Paid'],
        ]);
    }
}