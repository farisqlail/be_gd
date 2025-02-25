<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_method extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_payment',
        'va',
        'name_account',
        'deleted'
    ];
}
