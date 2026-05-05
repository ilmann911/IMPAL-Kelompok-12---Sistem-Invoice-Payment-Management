<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tb_produk';
    protected $primaryKey = 'id_produk';
    
    protected $guarded = [];

    public function rincianInvoice()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_produk', 'id_produk');
    }
}