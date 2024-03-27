<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Chirp;

class UserController extends Controller
{
    public function index(): View {
        return view('admin.index', [
            'users' => User::all(),
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
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