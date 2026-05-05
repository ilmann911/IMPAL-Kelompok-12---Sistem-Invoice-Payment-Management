<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'tb_invoice';
    protected $primaryKey = 'id_invoice';
    
    protected $guarded = [];

    public function klien()
    {
        return $this->belongsTo(Klien::class, 'id_klien', 'id_klien');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function rincian()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_invoice', 'id_invoice');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_invoice', 'id_invoice');
    }
}