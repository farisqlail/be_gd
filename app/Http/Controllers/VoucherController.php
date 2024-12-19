<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    // Display all vouchers
    public function index()
    {
        $vouchers = Voucher::all();
        return view('Menu.Vouchers.index', compact('vouchers'));
    }

    // Show form for creating a voucher
    public function create()
    {
        return view('Menu.Vouchers.create');
    }

    // Store a new voucher
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
        ]);

        Voucher::create($validatedData);
        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    // Show the edit form for a specific voucher
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('Menu.Vouchers.edit', compact('voucher'));
    }

    // Update an existing voucher
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
        ]);

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
