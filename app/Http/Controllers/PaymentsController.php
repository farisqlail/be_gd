<?php  
  
namespace App\Http\Controllers;  
  
use Illuminate\Http\Request;  
use App\Models\payment_method; 
  
class PaymentsController extends Controller  
{  
    /**  
     * Display a listing of the resource.  
     */  
    public function index()  
    {  
        $payments = payment_method::all(); 
        return view('Menu.payments.index', compact('payments')); 
    }  
  
    /**  
     * Show the form for creating a new resource.  
     */  
    public function create()  
    {  
        return view('Menu.payments.create'); 
    }  
  
    /**  
     * Store a newly created resource in storage.  
     */  
    public function store(Request $request)  
    {  
        $request->validate([  
            'name' => 'required',  
            'va' => 'required',  
            'name_account' => 'required',  
        ]);  
   
        payment_method::create([
            'nama_payment' => $request->name,
            'va' => $request->va,
            'name_account' => $request->name_account
        ]);  
  
        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');  
    }  
  
    /**  
     * Display the specified resource.  
     */  
    public function show(string $id)  
    {  
        $payment = payment_method::findOrFail($id);
        return view('Menu.payments.show', compact('payment')); 
    }  
  
    /**  
     * Show the form for editing the specified resource.  
     */  
    public function edit(string $id)  
    {  
        $payment = payment_method::findOrFail($id);
        return view('Menu.payments.edit', compact('payment')); 
    }  
  
    /**  
     * Update the specified resource in storage.  
     */  
    public function update(Request $request, string $id)  
    {  
        // Validate the request data  
        $request->validate([  
            'name' => 'required|string|max:255',  
            'va' => 'required|string|max:255',  
            'name_account' => 'required|string|max:255',  
        ]);  
  
        $payment = payment_method::findOrFail($id);
        $payment->update([
            'nama_payment' => $request->name,
            'va' => $request->va,
            'name_account' => $request->name_account
        ]);
  
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');  
    }  
  
    /**  
     * Remove the specified resource from storage.  
     */  
    public function destroy(string $id)  
    {  
        $payment = payment_method::findOrFail($id);
        $payment->delete(); 
  
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');  
    }  
}  
