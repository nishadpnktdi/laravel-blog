<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;


class IndexController extends Controller
{
    public function index()
    {
        $posts=Post::where('is_published',true)->orderBy('id','desc')->get();

        $featured_posts = Post::where('is_published',true)->where('is_featured',true)->orderBy('id','desc')->take(5)->get();

        $categories=Category::all();

        $tags=Tag::all();

        $recent_posts = Post::where('is_published',true)->orderBy('created_at','desc')->take(5)->get();

        return view('home', compact($posts, $featured_posts, $categories, $tags, $recent_posts));
    }
}
