<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    // Display all promos
    public function index()
    {
        $promos = Promo::all();
        return view('Menu.Promo.index', compact('promos'));
    }

    // Show a specific promo
    public function show($id)
    {
        $promo = Promo::find($id);
        if (!$promo) {
            return redirect()->back()->with('error', 'Promo not found');
        }
        return view('Promo.show', compact('promo'));
    }

    public function create()
    {
        return view('Menu.Promo.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'link_video' => 'nullable|url',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('promos', 'public');
            $validatedData['image'] = $imagePath;
        }

        Promo::create($validatedData);

        return redirect()->route('promos.index')->with('success', 'Promo created successfully.');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('Menu.Promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
    
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'link_video' => 'required|url',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
        ]);
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($promo->image) {
                Storage::delete('public/' . $promo->image);
            }
    
            // Simpan gambar baru
            $validatedData['image'] = $request->file('image')->store('promos', 'public');
        }
    
        $promo->update($validatedData);
    
        return redirect()->route('promos.index')->with('success', 'Promo updated successfully.');
    }
    

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('promos.index')->with('success', 'Promo deleted successfully.');
    }
}
