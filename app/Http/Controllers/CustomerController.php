<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Show list of customers
    public function index()
    {
        $customers = Customer::all();
        return view('Menu.Customers.index', compact('customers'));
    }

    // Show form to create a new customer
    public function create()
    {
        return view('Menu.Customers.create');
    }

    // Store a new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
            'number' => 'required|string|max:15',
            'point' => 'nullable|integer|min:0',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    // Show form to edit a customer
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('Menu.Customers.edit', compact('customer'));
    }

    // Update a customer
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'password' => 'nullable|string|min:6',
            'number' => 'required|string|max:15',
            'point' => 'nullable|integer|min:0',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
