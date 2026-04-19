<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'tb_klien';
    protected $primaryKey = 'id_klien';
    
    protected $guarded = [];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'id_klien', 'id_klien');
    }
}