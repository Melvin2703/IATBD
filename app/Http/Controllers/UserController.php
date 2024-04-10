<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aanvraag;
use Illuminate\View\View;
use App\Models\Post;

class UserController extends Controller
{
    public function index(): View {
        return view('admin.index', [
            'users' => User::all(),
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }

    public function getRowCount()
    {
        $rowCount = Aanvraag::count(); 
        return view('admin.index', ['rowCount' => $rowCount]);
    }

    public function block(User $user) {
        if($user->is_blocked == 1) {
            $user->is_blocked = 0;
        } else {
            $user->is_blocked = 1;
        }
        $user->save();
        return redirect(route('admin.index'));
    }

    public function admin(User $user) {
        if($user->is_admin == 1) {
            $user->is_admin = 0;
        } else {
            $user->is_admin = 1;
        }
        $user->save();
        return redirect(route('admin.index'));
    }
}