<?php  
  
namespace App\Http\Controllers;  
  
use App\Models\Banner;  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Storage;  
  
class BannerController extends Controller  
{  
    public function index()  
    {  
        $banners = Banner::all();  
        return view('Menu.banners.index', compact('banners'));  
    }  
  
    public function create()  
    {  
        return view('Menu.banners.create');  
    }  
  
    public function store(Request $request)  
    {  
        $request->validate([  
            'name' => 'required|string|max:255',  
            'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  
        ]);  
  
        $imagePath = $request->file('images')->store('banners', 'public');  
  
        Banner::create([  
            'name' => $request->name,  
            'images' => $imagePath,  
        ]);  
  
        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');  
    }  
  
    public function edit(Banner $banner)  
    {  
        return view('Menu.banners.edit', compact('banner'));  
    }  
  
    public function update(Request $request, Banner $banner)  
    {  
        $request->validate([  
            'name' => 'required|string|max:255',  
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  
        ]);  
  
        if ($request->hasFile('images')) {  
            // Delete old image  
            Storage::disk('public')->delete($banner->images);  
            $imagePath = $request->file('images')->store('banners', 'public');  
            $banner->images = $imagePath;  
        }  
  
        $banner->name = $request->name;  
        $banner->save();  
  
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');  
    }  
  
    public function destroy(Banner $banner)  
    {  
        // Delete the image from storage  
        Storage::disk('public')->delete($banner->images);  
        $banner->delete();  
  
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');  
    }  
}  
