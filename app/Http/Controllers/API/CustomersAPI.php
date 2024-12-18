<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomersAPI extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $customer = Customer::where('email', $validated['email'])->first();
    
        if ($customer && password_verify($validated['password'], $customer->password)) {
            // Generate a unique token using UUID
            $token = (string) Str::uuid();
    
            // Simpan token ke database
            $customer->update(['api_token' => $token]);
    
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'customer' => $customer,
                    'token' => $token,
                ]
            ], 200);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password',
        ], 401);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $customer = Customer::where('api_token', $token)->first();

        if ($customer) {
            $customer->update(['api_token' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Logout successful',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid token',
        ], 401);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customers = Customer::all();

            return response()->json([
                'success' => true,
                'message' => 'List of customers',
                'data' => $customers,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
                'password' => 'required|string|min:6',
                'number' => 'required|string|max:15',
                'point' => 'nullable|integer|min:0',
            ]);

            $validated['password'] = bcrypt($validated['password']);
            $customer = Customer::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully',
                'data' => $customer,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function profile(Request $request)
    {
        try {
            // Ambil token dari header
            $token = $request->header('Authorization');

            // Cari customer berdasarkan token
            $customer = Customer::where('api_token', $token)->first();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized or token invalid',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Customer details',
                'data' => $customer,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
                'data' => $customer,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }
    }
}
