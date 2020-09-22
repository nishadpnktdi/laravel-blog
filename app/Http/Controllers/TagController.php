<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class TagController extends Controller
{
    public function index($id)
    {
        $tag = Tag::query()->where('id', $id)->first();

        $posts = $tag->posts()->get();

        $categories = Category::all();

        $tags= Tag::all();

        $recent_posts = Post::where('is_published',true)->ordereBy('created_at','desc')->take(5)->get();

        return view('tag', compact($tag, $posts, $categories, $tags, $recent_posts));
    }
}
