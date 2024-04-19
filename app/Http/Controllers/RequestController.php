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
        $aanvragen = Aanvraag::all();
        return view('posts.index', ['aanvragen' => $aanvragen]);
    }
    
    public function store(Request $request)
    {   
        $post = Post::findOrFail($request->post_id);

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
        $aanvraag = Aanvraag::where('user_id_request', $user_id)
                            ->where('post_id', $post_id)
                            ->first();
    
        if (!$aanvraag) {
            return response()->json(['message' => 'Verzoek niet gevonden.'], 404);
        }
    
        $aanvraag->delete();
    
        return redirect(route('posts.index'));
    }

    public function updateAccepted($id) {
        $aanvraag = Aanvraag::findOrFail($id);
        $aanvraag->accepted = 1;
        $aanvraag->save();

        Aanvraag::where('post_id', $aanvraag->post_id)
                ->where('id', '!=', $id)
                ->update(['accepted' => 2]);

        return redirect()->back()->with('success', 'Aanvraag geaccepteerd.');
    } 
}
