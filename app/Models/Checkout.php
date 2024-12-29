<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_price',
        'id_promo',
        'customer_name',
        'email_customer',
        'phone_customer',
        'transaction_code',
        'amount',
        'payment_status'
    ];
}
