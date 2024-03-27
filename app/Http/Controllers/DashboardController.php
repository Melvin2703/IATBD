<?php

namespace App\Http\Controllers;

use App\Models\Chirp; // Import the Chirp model
use Illuminate\Http\Request;
use Illuminate\View\View; // Import the View class

class DashboardController extends Controller
{
    public function index(): View
    {
        $chirps = Chirp::with('user')->latest()->get();
    
        return view('dashboard', compact('chirps')); // Add a semicolon here
    }    
}
