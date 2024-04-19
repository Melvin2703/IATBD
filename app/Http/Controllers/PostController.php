<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Models\Animal;
use App\Models\Aanvraag; 
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $animals = Animal::All();
        $posts = Post::with('user')->latest()->get();
        $aanvragen = Aanvraag::All();

        return view('posts.index', ['animals' => $animals, 'posts' => $posts, 'aanvragen' => $aanvragen] ); 
    }

    public function create()
    {
        //
    }

    public function filter(Request $request)
    {
        $selectedAnimal = $request->input('animal');
        $sortByDate = $request->input('sort', 'desc');
    
        $query = Post::query();
    
        if ($selectedAnimal !== null) {
            $query->where('animal', $selectedAnimal);
        }

        $query->orderBy('created_at', $sortByDate);
    
        $posts = $query->get();

        $animals = Post::select('animal')->distinct()->get();

        return view('posts.index', compact('posts', 'animals'));
    }
   
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
             $imageName = time().'.'.$image->extension(); 
             $image->storeAs('public/images', $imageName); 
         }

         if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time().'.'.$video->extension(); 
            $video->storeAs('public/video', $videoName); 
        }
     
         Post::create([
             'message' => $request->input('message'),
             'animal' => $request->input('animal'),
             'description' => $request->input('description'),
             'user_id' => Auth()->user()->id,
             'image' => $imageName ?? null,
             'video' => $videoName ?? null,
         ]);
     
         return redirect(route('posts.index')); 
     }

    public function show(post $post)
    {
        //
    }

    public function edit(Post $post): View
    {
        $animals = Animal::all();
        $this->authorize('update', $post);
    
        return view('posts.edit', [
            'post' => $post,
            'animals' => $animals, 
            'description' => $post->description,
            'image' => $post->image,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'animal' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/images/' . $post->image);
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); 

            $validated['image'] = $imageName;

            $image->storeAs('public/images', $imageName); 
        }

        if ($request->hasFile('video')) {
            Storage::delete('public/video/' . $post->video);
            $video = $request->file('video');
            $videoName = time().'.'.$video->extension();
            $validated['video'] = $videoName;
            $video->storeAs('public/video', $videoName);
        }
 
        $post->update($validated);
 
        return redirect(route('posts.index'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
 
        if ($post->image) {
            Storage::delete('public/images/' . $post->image);
        }

        if ($post->video) {
            Storage::delete('public/video/' . $post->video);
        }

        $post->delete();
 
        return redirect(route('posts.index'));
    }
}
