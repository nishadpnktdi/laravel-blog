<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class CategoryController extends Controller
{
    public function index($id)
    {
        $category = Category::query()->where('id', $id)->first();

        $posts = $category->posts()->get();

        $categories = Category::all();

        $tags = Tag::all();

        $recent_posts = Post::where('is_published', true)->orderBy('created_at', 'desc')->take(5)->get();

        return view('category', compact($category, $posts, $categories, $tags, $recent_posts));
    }
}
