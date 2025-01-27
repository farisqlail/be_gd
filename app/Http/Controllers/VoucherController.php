<?php

namespace App\Http\Controllers;

use App\Models\product_type;
use App\Models\variance;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    // Display all vouchers
    public function index()
    {
        $vouchers = Voucher::with(['variance', 'productType'])->get();  
        return view('Menu.Vouchers.index', compact('vouchers'));
    }

    // Show form for creating a voucher
    public function create()
    {
        $variances = variance::all();
        $productTypes = product_type::all();

        return view('Menu.Vouchers.create', compact('variances', 'productTypes'));
    }

    // Store a new voucher
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'id_variance' => 'required|exists:variances,id', // Validate variance  
            'id_product_type' => 'required|exists:product_types,id', // Validate product type  
        ]);

        Voucher::create($validatedData);
        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    // Show the edit form for a specific voucher
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $variances = Variance::all(); // Fetch all variances  
        $productTypes = product_type::all(); // Fetch all product types  

        return view('Menu.Vouchers.edit', compact('voucher', 'variances', 'productTypes'));
    }


    // Update an existing voucher
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'id_variance' => 'required|exists:variances,id', // Validate variance  
            'id_product_type' => 'required|exists:product_types,id', // Validate product type  
        ]);

        $voucher = Voucher::findOrFail($id);
        $voucher->update($validatedData);
        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    // Delete a voucher
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully.');
    }
}
