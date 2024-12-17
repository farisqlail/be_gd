<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produks extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_varian',
        'id_jenis',
        'durasi',
        'ket_durasi',
        'batas_pengguna',
        'deskripsi',
    ];
}
