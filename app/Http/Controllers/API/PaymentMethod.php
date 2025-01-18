<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\payment_method;
use Illuminate\Http\Request;

class PaymentMethod extends Controller
{
    public function index()  
    {  
        $payments = payment_method::all(); 
        
        return response()->json([
            'data' => $payments
        ], 200);
    }  
}
