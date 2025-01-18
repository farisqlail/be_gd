<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;

class SendReminder extends Command
{
    protected $signature = 'reminder:send';
    protected $description = 'Send reminders for transactions expiring in 3 days';

    public function handle()
    {
        // Get the current date and the date 3 days from now  
        $now = now();
        $threeDaysFromNow = now()->addDays(3);

        // Fetch transactions that are expiring in 3 days  
        $transactions = Transaction::where('tanggal_berakhir', '>=', $now)
            ->where('tanggal_berakhir', '<=', $threeDaysFromNow)
            ->get();

        foreach ($transactions as $transaction) {
            $this->sendReminder($transaction);
        }

        $this->info('Reminders sent for ' . $transactions->count() . ' transactions.');
    }

    protected function sendReminder($transaction)
    { 
        return (object) [
            'name' => $transaction->nama_customer,
            'wa' => $transaction->wa
        ];
    }
}
