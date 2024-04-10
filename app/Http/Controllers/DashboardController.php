<?php

namespace App\Http\Controllers;

use App\Models\Post; // Import the Chirp model
use App\Models\Aanvraag;
use Illuminate\Http\Request;
use Illuminate\View\View; // Import the View class

class DashboardController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('user')->latest()->get();
        $aanvragen = Aanvraag::All();
        return view('dashboard', ['posts' => $posts, 'aanvragen' => $aanvragen]); 
    }    
}
