<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; 

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id_request' => 'required', // Voeg deze regel toe om ervoor te zorgen dat user_id_request aanwezig is
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);
    
        // Haal de user_id_request op uit het verzoek
        $user_id_request = $validatedData['user_id_request'];
    
        $review = new Review();
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        $review->user_id = $user_id_request; // Voeg de user_id_request toe aan de review
    
        $review->save();
    
        return redirect()->back()->with('success', 'Review geplaatst!');
    }    
}
