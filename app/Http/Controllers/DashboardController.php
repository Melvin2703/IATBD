<?php

namespace App\Http\Controllers;

use App\Models\Post; // Import the Chirp model
use Illuminate\Http\Request;
use Illuminate\View\View; // Import the View class

class DashboardController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('user')->latest()->get();
    
        return view('dashboard', compact('posts')); // Add a semicolon here
    }    
}
