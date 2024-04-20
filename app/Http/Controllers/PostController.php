<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
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
    
        $posts = Post::query();
    
        if ($selectedAnimal !== null && $selectedAnimal !== 'all') {
            $posts->where('animal', $selectedAnimal);
        }        
    
        if ($request->filled('start_date_filter') && $request->filled('end_date_filter')) {
            $posts->whereDate('start_date', '>=', $request->input('start_date_filter'))
                ->whereDate('end_date', '<=', $request->input('end_date_filter'));
        }
    
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $posts->whereBetween('price', [$request->input('price_min'), $request->input('price_max')]);
        }
    
        $posts->orderBy('created_at', $sortByDate);
    
        $posts = $posts->get();
    
        $animals = Animal::all();
    
        $animalsWithAll = $animals->pluck('name', 'id')->prepend('Alle dieren', 'all');
    
        return view('posts.index', ['animals' => $animals, 'posts' => $posts, 'animalsWithAll' => $animalsWithAll]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:10',
            'animal' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
    
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); 
            $image->storeAs('public/images', $imageName); 
        }
    
        Post::create([
            'message' => $request->input('message'),
            'animal' => $request->input('animal'),
            'description' => $request->input('description'),
            'user_id' => Auth()->user()->id,
            'price' => $request->input('price'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'image' => $imageName,
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
            'price' => $post->price,
            'start_date' => $post->start_date,
            'end_date' => $post->end_date,
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
            'price' => 'required|numeric',
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d|after_or_equal:start_date',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/images/' . $post->image);
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension(); 

            $validated['image'] = $imageName;

            $image->storeAs('public/images', $imageName); 
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

        $post->delete();
 
        return redirect(route('posts.index'));
    }
}
