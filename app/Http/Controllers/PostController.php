<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostController extends Controller
{
    public function index($id)
    {
        $post = Post::query()->where('is_published',true)->where('id', $id)->first();

        $categories = Category::all();

        $tags = Tag::all();

        $recent_posts = Post::where('is_published', true)->orderBy('created_at', 'desc')->take(5)->get();

        return view('post', compact($post,$categories,$tags,$recent_posts));
    }
}
