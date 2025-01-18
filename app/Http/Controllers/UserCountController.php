<?php  
  
namespace App\Http\Controllers;  
  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\DB;  
use Carbon\Carbon;  
  
class UserCountController extends Controller  
{  
    /**  
     * Display the current user count.  
     */  
    public function index()  
    {  
        $userCount = DB::table('user_counts')->first();  
        return view('Menu.user_counts.index', compact('userCount'));  
    }  
  
    /**  
     * Increment the user count by 50 if a day has passed.  
     */  
    public function incrementCount()  
    {  
        $userCount = DB::table('user_counts')->first();  
  
        if (!$userCount) {  
            // If no record exists, create one  
            DB::table('user_counts')->insert([  
                'count' => 50,  
                'last_updated' => Carbon::now(),  
                'created_at' => now(),  
                'updated_at' => now(),  
            ]);  
        } else {  
            // Check if a day has passed since the last update  
            if (Carbon::now()->diffInDays($userCount->last_updated) >= 1) {  
                DB::table('user_counts')->where('id', $userCount->id)->update([  
                    'count' => $userCount->count + 50,  
                    'last_updated' => Carbon::now(),  
                    'updated_at' => now(),  
                ]);  
            }  
        }  
  
        return redirect()->route('user_counts.index')->with('success', 'User count updated successfully.');  
    }  
}  
