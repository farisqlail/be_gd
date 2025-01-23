<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trending;
use Illuminate\Support\Facades\Storage;


class TrendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trendings = Trending::all();
        return view('Menu.Trending.index', compact('trendings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Menu.Trending.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('trendings', 'public');
            $validatedData['image'] = $imagePath;
        }
        
        

        Trending::create($validatedData);

        return redirect()->route('trendings.index')->with('success', 'Trending created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trending = Trending::findOrFail($id);
        return view('Menu.Trending.edit', compact('trending'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $trending = Trending::findOrFail($id);
            $trending->title = $validatedData['title'];
            $trending->caption = $validatedData['caption'];

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('trendings', 'public');
                $trending->image = $imagePath;
            }

            $trending->save();

            return redirect()->route('trendings.index')->with('success', 'Trending updated successfully.');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trending = Trending::findOrFail($id);
        $trending->delete();

        return redirect()->route('trendings.index')->with('success', 'Trending deleted successfully.');
    }
}
