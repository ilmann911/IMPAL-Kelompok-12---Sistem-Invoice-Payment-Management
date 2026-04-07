<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'tb_klien';
    protected $primaryKey = 'id_klien';
    
    // Mengizinkan semua kolom diisi (Mass Assignment)
    protected $guarded = [];

    // Relasi ke tabel Klien
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'id_klien', 'id_klien');
    }
}