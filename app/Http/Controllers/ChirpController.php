<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Models\Chirp;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(): View
{
    $animals = Animal::all();
    $chirps = Chirp::with('user')->latest()->get();

    return view('chirps.index', compact('chirps', 'animals'))
                ->with('dashboard', $chirps); // Voeg de variabele chirpsForDashboard toe aan de view voor dashboard.blade.php
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   
     public function store(Request $request)
     {       
         $validated = $request->validate([
             'message' => 'required|string|max:10',
             'animal' => 'required|string',
             'description' => 'required|string',
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
             'video' => 'mimes:mp4'
         ]);
         
         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $imageName = time().'.'.$image->extension(); // Genereer een unieke naam voor de afbeelding
             $image->storeAs('public/images', $imageName); // Sla de afbeelding op in de opslag (bijv. public/images)
         }

         if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time().'.'.$video->extension(); // Genereer een unieke naam voor de afbeelding
            $video->storeAs('public/video', $videoName); // Sla de afbeelding op in de opslag (bijv. public/images)
        }
     
         Chirp::create([
             'message' => $request->input('message'),
             'animal' => $request->input('animal'),
             'description' => $request->input('description'),
             'user_id' => Auth()->user()->id,
             'image' => $imageName ?? null,
             'video' => $videoName ?? null,
         ]);
     
         return redirect(route('chirps.index')); // Redirect naar waar je maar wilt na het opslaan van de chirp
     }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        $animals = Animal::all();
        $this->authorize('update', $chirp);
    
        return view('chirps.edit', [
            'chirp' => $chirp,
            'animals' => $animals, 
            'description' => $chirp->description,
            'image' => $chirp->image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'animal' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/images/' . $chirp->image);
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); // Genereer een unieke naam voor de afbeelding
    
            // Wijs de naam van de afbeelding toe aan de 'image' sleutel in het $validated array
            $validated['image'] = $imageName;
    
            // Sla de afbeelding op in de opgegeven map (bijv. public/images) op de lokale schijf
            $image->storeAs('public/images', $imageName); 
        }

        if ($request->hasFile('video')) {
            Storage::delete('public/video/' . $chirp->video);
            $video = $request->file('video');
            $videoName = time().'.'.$video->extension(); // Genereer een unieke naam voor de afbeelding
            
            $validated['video'] = $videoName;

            $video->storeAs('public/video', $videoName);
        }
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);
 
        if ($chirp->image) {
            Storage::delete('public/images/' . $chirp->image);
        }

        if ($chirp->video) {
            Storage::delete('public/video/' . $chirp->video);
        }

        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
