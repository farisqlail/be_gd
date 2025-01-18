<?php  
  
namespace App\Console\Commands;  
  
use Illuminate\Console\Command;  
use Illuminate\Support\Facades\DB;  
use Carbon\Carbon;  
  
class IncrementUserCount extends Command  
{  
    protected $signature = 'usercount:increment';  
    protected $description = 'Increment user count by 50 every day';  
  
    public function handle()  
    {  
        $userCount = DB::table('user_counts')->first();  
  
        if (!$userCount) {  
            DB::table('user_counts')->insert([  
                'count' => 50,  
                'last_updated' => Carbon::now(),  
                'created_at' => now(),  
                'updated_at' => now(),  
            ]);  
        } else {  
            if (Carbon::now()->diffInDays($userCount->last_updated) >= 1) {  
                DB::table('user_counts')->where('id', $userCount->id)->update([  
                    'count' => $userCount->count + 50,  
                    'last_updated' => Carbon::now(),  
                    'updated_at' => now(),  
                ]);  
            }  
        }  
    }  
}  
