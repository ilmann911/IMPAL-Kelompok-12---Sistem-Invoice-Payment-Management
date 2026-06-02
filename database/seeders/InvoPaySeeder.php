<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InvoPaySeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA ADMIN
        DB::table('tb_admin')->insert([
            'nama_admin' => 'Admin Utama',
            'email' => 'admin@invopay.com',
            'password' => Hash::make('admin123'),
        ]);

        // 2. DATA KLIEN
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
        ]);

        // 3. DATA PRODUK & JASA (Sudah ditambahkan kode_produk & satuan)
        DB::table('tb_produk')->insert([
            ['kode_produk' => 'PRD-001', 'nama_produk' => 'Jasa Pembuatan Website (Company Profile)', 'harga_satuan' => 5000000, 'satuan' => 'Paket'],
            ['kode_produk' => 'PRD-002', 'nama_produk' => 'Jasa Pembuatan Website (E-Commerce)', 'harga_satuan' => 12500000, 'satuan' => 'Paket'],
            ['kode_produk' => 'PRD-003', 'nama_produk' => 'Maintenance Server & Website (Bulanan)', 'harga_satuan' => 1500000, 'satuan' => 'Bulan'],
            ['kode_produk' => 'PRD-004', 'nama_produk' => 'Desain Logo & Identitas Branding', 'harga_satuan' => 3000000, 'satuan' => 'Paket'],
            ['kode_produk' => 'PRD-005', 'nama_produk' => 'Jasa SEO & Digital Marketing (Bulanan)', 'harga_satuan' => 4200000, 'satuan' => 'Bulan'],
            ['kode_produk' => 'PRD-006', 'nama_produk' => 'Konsultasi IT & Keamanan Jaringan', 'harga_satuan' => 2500000, 'satuan' => 'Jam'],
        ]);

        // 4. DATA INVOICE
        DB::table('tb_invoice')->insert([
            // --- TAHUN 2025 ---
            ['no_invoice' => 'INV-202501-001', 'id_klien' => 1, 'id_admin' => 1, 'tanggal_buat' => '2025-01-10', 'tanggal_jatuh_tempo' => '2025-01-24', 'total' => 5000000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202502-002', 'id_klien' => 2, 'id_admin' => 1, 'tanggal_buat' => '2025-02-15', 'tanggal_jatuh_tempo' => '2025-02-28', 'total' => 1500000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202503-003', 'id_klien' => 3, 'id_admin' => 1, 'tanggal_buat' => '2025-03-05', 'tanggal_jatuh_tempo' => '2025-03-19', 'total' => 12500000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202505-004', 'id_klien' => 4, 'id_admin' => 1, 'tanggal_buat' => '2025-05-20', 'tanggal_jatuh_tempo' => '2025-06-03', 'total' => 3000000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202508-005', 'id_klien' => 5, 'id_admin' => 1, 'tanggal_buat' => '2025-08-11', 'tanggal_jatuh_tempo' => '2025-08-25', 'total' => 4200000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202510-006', 'id_klien' => 6, 'id_admin' => 1, 'tanggal_buat' => '2025-10-10', 'tanggal_jatuh_tempo' => '2025-10-24', 'total' => 5000000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202511-007', 'id_klien' => 7, 'id_admin' => 1, 'tanggal_buat' => '2025-11-25', 'tanggal_jatuh_tempo' => '2025-12-09', 'total' => 1500000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202512-008', 'id_klien' => 8, 'id_admin' => 1, 'tanggal_buat' => '2025-12-01', 'tanggal_jatuh_tempo' => '2025-12-15', 'total' => 3000000, 'status' => 'Paid'],

            // --- TAHUN 2026 ---
            ['no_invoice' => 'INV-202601-009', 'id_klien' => 9, 'id_admin' => 1, 'tanggal_buat' => '2026-01-15', 'tanggal_jatuh_tempo' => '2026-01-29', 'total' => 12500000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202602-010', 'id_klien' => 10, 'id_admin' => 1, 'tanggal_buat' => '2026-02-10', 'tanggal_jatuh_tempo' => '2026-02-24', 'total' => 4200000, 'status' => 'Paid'],
            ['no_invoice' => 'INV-202603-011', 'id_klien' => 1, 'id_admin' => 1, 'tanggal_buat' => '2026-03-05', 'tanggal_jatuh_tempo' => '2026-03-19', 'total' => 2500000, 'status' => 'Paid'],
            
            // Status Selain Paid
            ['no_invoice' => 'INV-202604-012', 'id_klien' => 2, 'id_admin' => 1, 'tanggal_buat' => '2026-04-12', 'tanggal_jatuh_tempo' => '2026-04-26', 'total' => 1500000, 'status' => 'Overdue'],
            ['no_invoice' => 'INV-202604-013', 'id_klien' => 3, 'id_admin' => 1, 'tanggal_buat' => '2026-04-25', 'tanggal_jatuh_tempo' => '2026-05-09', 'total' => 5000000, 'status' => 'Overdue'],
            ['no_invoice' => 'INV-202605-014', 'id_klien' => 4, 'id_admin' => 1, 'tanggal_buat' => '2026-05-02', 'tanggal_jatuh_tempo' => '2026-05-16', 'total' => 3000000, 'status' => 'Sent'],
            ['no_invoice' => 'INV-202605-015', 'id_klien' => 5, 'id_admin' => 1, 'tanggal_buat' => '2026-05-10', 'tanggal_jatuh_tempo' => '2026-05-24', 'total' => 4200000, 'status' => 'Pending'],
            ['no_invoice' => 'INV-202605-016', 'id_klien' => 6, 'id_admin' => 1, 'tanggal_buat' => '2026-05-15', 'tanggal_jatuh_tempo' => '2026-05-29', 'total' => 12500000, 'status' => 'Draft'],
            ['no_invoice' => 'INV-202605-017', 'id_klien' => 7, 'id_admin' => 1, 'tanggal_buat' => '2026-05-18', 'tanggal_jatuh_tempo' => '2026-06-01', 'total' => 1500000, 'status' => 'Draft'],
        ]);

        // 5. DATA PEMBAYARAN
        DB::table('tb_pembayaran')->insert([
            ['id_invoice' => 1, 'tanggal_bayar' => '2025-01-12', 'jumlah_bayar' => 5000000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 2, 'tanggal_bayar' => '2025-02-18', 'jumlah_bayar' => 1500000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 3, 'tanggal_bayar' => '2025-03-06', 'jumlah_bayar' => 12500000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 4, 'tanggal_bayar' => '2025-05-22', 'jumlah_bayar' => 3000000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 5, 'tanggal_bayar' => '2025-08-15', 'jumlah_bayar' => 4200000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 6, 'tanggal_bayar' => '2025-10-15', 'jumlah_bayar' => 5000000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 7, 'tanggal_bayar' => '2025-11-28', 'jumlah_bayar' => 1500000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 8, 'tanggal_bayar' => '2025-12-05', 'jumlah_bayar' => 3000000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 9, 'tanggal_bayar' => '2026-01-20', 'jumlah_bayar' => 12500000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 10, 'tanggal_bayar' => '2026-02-12', 'jumlah_bayar' => 4200000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 11, 'tanggal_bayar' => '2026-03-10', 'jumlah_bayar' => 2500000, 'status_verifikasi' => 'Paid'],
            ['id_invoice' => 15, 'tanggal_bayar' => '2026-05-18', 'jumlah_bayar' => 4200000, 'status_verifikasi' => 'Pending'],
        ]);
    }
}