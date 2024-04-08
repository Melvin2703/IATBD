<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getData()
    {
        $animals = Animal::all();
        return view('posts.index', compact('animals'));
    }
}
