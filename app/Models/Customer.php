<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_akun',
        'name',
        'email',
        'password',
        'number',
        'point',
        'api_token',
    ];

    public function akun()  
    {  
        return $this->belongsTo(Akun::class, 'id_akun');  
    }  
}
