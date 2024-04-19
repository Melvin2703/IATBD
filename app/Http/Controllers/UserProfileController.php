<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $reviews = $user->reviews;
        $averageRating = $reviews->isNotEmpty() ? number_format($reviews->avg('rating'), 1) : null;

        if (!$user) {
            abort(404, 'Gebruiker niet gevonden');
        }

        return view('user.profile', ['user' => $user, 'averageRating' => $averageRating, 'reviews' => $reviews]);
    }
}
