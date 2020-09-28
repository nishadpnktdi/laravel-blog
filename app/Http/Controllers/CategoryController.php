<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;


use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('category/create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|min:3|max:255|string|unique:categories'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->withSuccess('Category created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tags = Tag::get();
        $categories = Category::withCount('posts')->get();
        $posts = Post::whereHas('category', function($query) use ($id){
            return $query->where('id', $id);
        })->latest()->paginate(6);
        $latest = Post::limit(5)->latest()->get();
        $category=Category::find($id);
        return view('category/category')->with(compact("category","posts", "categories", "tags", "latest"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request, [
            'name'  => 'required|min:3|max:255|string|unique:categories'
        ]);
            $category = Category::find($id);
            $category->name = $request->name;
            $category->name = $validatedData['name'];
            $category->save();

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = new Category();

        $category->where('id', $id)->delete();

        return redirect()->route('category.index')->withSuccess('Category deleted!');
    }
}
