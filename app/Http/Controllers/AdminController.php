<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class AdminController extends Controller
{
    public function __invoke() {

        $posts = Post::get();

        return view('admin/dashboard')->with(compact("posts"));
    }
}
