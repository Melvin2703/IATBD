<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aanvraag; 
use App\Models\Post;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(): View
    {
        $aanvragen = Aanvraag::all(); // veronderstel dat Aanvraag het model is voor de aanvragen
        return view('posts.index', ['aanvragen' => $aanvragen]);
        // compact('aanvragen')
    }
    
    public function store(Request $request)
    {   
        // Valideer de invoer indien nodig
        $post = Post::findOrFail($request->post_id);

        // Maak de aanvraag aan en koppel de gebruiker en de post
        Aanvraag::create([
            'user_id_request' => auth()->user()->id, 
            'post_id' => $request->post_id,
            'user_id_post' => $post->user_id, 
            'accepted' => 0
        ]);
        
        return redirect()->route('posts.index')->with('message', 'Verzoek verzonden!');
    }

    public function destroy($user_id, $post_id)
    {
        // Zoek het verzoek in de database op basis van de gebruikers-ID en post-ID
        $aanvraag = Aanvraag::where('user_id_request', $user_id)
                            ->where('post_id', $post_id)
                            ->first();
    
        if (!$aanvraag) {
            return response()->json(['message' => 'Verzoek niet gevonden.'], 404);
        }
    
        // Verwijder het verzoek uit de database
        $aanvraag->delete();
    
        return redirect(route('posts.index'));
    }
}
