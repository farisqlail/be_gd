<?php

namespace App\Http\Controllers;

use App\Models\VideoTutorial;
use Illuminate\Http\Request;

class VideoTutorialController extends Controller
{
    /**  
     * Display a listing of the resource.  
     *  
     * @return \Illuminate\Http\Response  
     */
    public function index()
    {
        $videoTutorials = VideoTutorial::all();
        return view('Menu.video_tutorials.index', compact('videoTutorials'));
    }

    /**  
     * Show the form for creating a new resource.  
     *  
     * @return \Illuminate\Http\Response  
     */
    public function create()
    {
        return view('Menu.video_tutorials.create');
    }

    /**  
     * Store a newly created resource in storage.  
     *  
     * @param  \Illuminate\Http\Request  $request  
     * @return \Illuminate\Http\Response  
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link_video' => 'required|url',
            'account' => 'required|string|max:255',
        ]);

        VideoTutorial::create($request->all());

        return redirect()->route('video_tutorials.index')->with('success', 'Video Tutorial created successfully.');
    }

    /**  
     * Display the specified resource.  
     *  
     * @param  \App\Models\VideoTutorial  $videoTutorial  
     * @return \Illuminate\Http\Response  
     */
    public function show(VideoTutorial $videoTutorial) {}

    /**  
     * Show the form for editing the specified resource.  
     *  
     * @param  \App\Models\VideoTutorial  $videoTutorial  
     * @return \Illuminate\Http\Response  
     */
    public function edit(VideoTutorial $videoTutorial)
    {
        return view('Menu.video_tutorials.edit', compact('videoTutorial'));
    }

    /**  
     * Update the specified resource in storage.  
     *  
     * @param  \Illuminate\Http\Request  $request  
     * @param  \App\Models\VideoTutorial  $videoTutorial  
     * @return \Illuminate\Http\Response  
     */
    public function update(Request $request, VideoTutorial $videoTutorial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link_video' => 'required|url',
            'account' => 'required|string|max:255',
        ]);

        $videoTutorial->update($request->all());

        return redirect()->route('video_tutorials.index')->with('success', 'Video Tutorial updated successfully.');
    }

    /**  
     * Remove the specified resource from storage.  
     *  
     * @param  \App\Models\VideoTutorial  $videoTutorial  
     * @return \Illuminate\Http\Response  
     */
    public function destroy(VideoTutorial $videoTutorial)
    {
        $videoTutorial->delete();

        return redirect()->route('video_tutorials.index')->with('success', 'Video Tutorial deleted successfully.');
    }
}
