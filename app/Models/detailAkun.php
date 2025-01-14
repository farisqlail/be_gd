<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailAkun extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_akun',
        'profile',
        'pin',
        'jumlah_pengguna'
    ];
}
