<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_price',
        'customer_name',
        'transaction_code',
        'amount',
        'payment_status',
        'promo'
    ];
}
