<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_checkout extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_checkout',
        'id_detail_akun',
        'keterangan'
        ];
}
