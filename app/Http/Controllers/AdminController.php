<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function __invoke()
    {

        if (Gate::allows('isAdmin') || Gate::allows('isEditor')) {

            $posts = Post::get();

            return view('admin/dashboard')->with(compact("posts"));

        } else {

            $currentuser = Auth::user();

            $posts = Post::where('user_id', '=', $currentuser->id)->get();

            return view('admin/dashboard')->with(compact("posts"));
        }
    }
}
