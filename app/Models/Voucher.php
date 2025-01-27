<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_variance',
        'id_product_type',
        'name',
        'amount'
    ];

    public function variance()  
    {  
        return $this->belongsTo(Variance::class, 'id_variance');  
    }  
  
    public function productType()  
    {  
        return $this->belongsTo(product_type::class, 'id_product_type');  
    } 
}
