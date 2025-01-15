<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;  
use App\Models\Transaction;  
use Illuminate\Http\JsonResponse;  
use Illuminate\Http\Request;  
  
class TransactionReminderController extends Controller  
{  
    public function getExpiringTransactions(Request $request): JsonResponse  
    {  
        // Get the current date and the date 3 days from now  
        $now = now();  
        $threeDaysFromNow = now()->addDays(3);  
  
        // Fetch transactions that are expiring in 3 days  
        $transactions = Transaction::where('tanggal_berakhir', '>=', $now)  
            ->where('tanggal_berakhir', '<=', $threeDaysFromNow)  
            ->get(['wa']); // Only select the 'wa' column  
  
        // Extract WhatsApp numbers  
        $waNumbers = $transactions->pluck('wa');  
  
        return response()->json([  
            'success' => true,  
            'wa_numbers' => $waNumbers,  
            'message' => 'WhatsApp numbers fetched successfully.'  
        ], 200);  
    }  
}  
