<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'tb_invoice';
    protected $primaryKey = 'id_invoice';
    
    // Mengizinkan semua kolom diisi (Mass Assignment)
    protected $guarded = [];

    // Relasi ke Klien (Siapa yang ditagih)
    public function klien()
    {
        return $this->belongsTo(Klien::class, 'id_klien', 'id_klien');
    }

    // Relasi ke Admin (Siapa yang membuat)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // Relasi ke Detail (Apa saja itemnya)
    public function rincian()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_invoice', 'id_invoice');
    }

    // Relasi ke Pembayaran (Bukti bayarnya)
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_invoice', 'id_invoice');
    }
}