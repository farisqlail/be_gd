<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Menampilkan daftar testimonial
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('Menu.Testimonial.index', compact('testimonials'));
    }

    // Menampilkan form untuk membuat testimonial baru
    public function create()
    {
        return view('Menu.Testimonial.create');
    }

    // Menyimpan testimonial baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        Testimonial::create([
            'name' => $request->name,
            'deskripsi' => $request->description,
        ]);

        return redirect()->route('testimonial.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('Menu.Testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        // Update testimonial
        $testimonial->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('testimonial.index')->with('success', 'Testimonial updated successfully.');
    }

    // Menghapus testimonial
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return redirect()->route('testimonial.index')->with('success', 'Testimonial deleted successfully.');
    }
}
