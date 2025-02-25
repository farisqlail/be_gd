<?php

namespace App\Http\Controllers;

use App\Models\WaAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WaAdminController extends Controller
{
    /**  
     * Display a listing of the resource.  
     */
    public function index()
    {
        $waAdmins = WaAdmin::all();

        return view('Menu.wa_admin.index', compact('waAdmins'));
    }

    /**  
     * Show the form for creating a new resource.  
     */
    public function create()
    {
        return view('Menu.wa_admin.create');
    }

    /**  
     * Store a newly created resource in storage.  
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        WaAdmin::create([
            'name' => $request->name,
            'wa' => $request->wa,
            'logo' => $request->file('logo')->store('waadmin', 'public')
        ]);

        return redirect()->route('wa_admin.index')->with('success', 'WA Admin created successfully.');
    }

    /**  
     * Display the specified resource.  
     */
    public function show(string $id)
    {
        $waAdmin = WaAdmin::findOrFail($id);
        return view('Menu.wa_admin.show', compact('waAdmin'));
    }

    /**  
     * Show the form for editing the specified resource.  
     */
    public function edit(string $id)
    {
        $waAdmin = WaAdmin::findOrFail($id);
        return view('Menu.wa_admin.edit', compact('waAdmin'));
    }

    /**  
     * Update the specified resource in storage.  
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $waAdmin = WaAdmin::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($waAdmin->logo) {
                Storage::delete('public/' . $waAdmin->logo);
            }

            $waAdmin->update([
                'name' => $request->name,
                'wa' => $request->wa,
                'logo' => $request->file('logo')->store('logo', 'public')
            ]);
        } else {
            $waAdmin->update([
                'name' => $request->name,
                'wa' => $request->wa,
                'logo' => $waAdmin->logo
            ]);
        }

        return redirect()->route('wa_admin.index')->with('success', 'WA Admin updated successfully.');
    }

    /**  
     * Remove the specified resource from storage.  
     */
    public function destroy(string $id)
    {
        $waAdmin = WaAdmin::findOrFail($id);
        $waAdmin->delete();

        return redirect()->route('wa_admin.index')->with('success', 'WA Admin deleted successfully.');
    }
}
