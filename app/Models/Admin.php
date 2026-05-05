<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk Login
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['nama_admin', 'email', 'password'];
    protected $hidden = ['password'];
}
