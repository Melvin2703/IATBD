<?php

namespace App\Http\Controllers;

use Auth;
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
    
        return view('chirps.index', compact('chirps', 'animals'));
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
        ]);
        
        Chirp::create([
            'message' => $request->input('message'),
            'animal' => $request->input('animal'),
            'description' => $request->input('description'),
            'user_id' => Auth()->user()->id,
        ]);

        return redirect(route('chirps.index')); // Redirect to wherever you want after storing the chirp
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         'message' => 'required|string|max:255',
    //     ]);

    //     $request->user()->chirps()->create($validated);

    //     return redirect(route('chirps.index'));
    // }

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
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
