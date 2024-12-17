<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

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
            'link_video' => 'required|url',
            'deskripsi' => 'required|string',
        ]);

        Promo::create($validatedData);
        return redirect()->route('promos.index')->with('success', 'Promo created successfully.');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('Menu.Promo.edit', compact('promo'));
    }

    // Update an existing promo
    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        if (!$promo) {
            return redirect()->back()->with('error', 'Promo not found');
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'link_video' => 'sometimes|url',
            'deskripsi' => 'sometimes|string',
        ]);

        $promo->update($validatedData);
        return redirect()->route('promos.index')->with('success', 'Promo updated successfully');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('promos.index')->with('success', 'Promo deleted successfully.');
    }
}
