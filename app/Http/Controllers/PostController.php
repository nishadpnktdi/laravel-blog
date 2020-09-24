<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::get();

        return view('index')->with(compact("post"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $tags = Tag::get();
        return view('post/create')->with(compact("categories", "tags"));
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
            'title' => 'required|unique:posts',
            'author' => 'required',
            'content' => 'required',
            'category' => 'required',
            'image'=>'mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post();

        $imageName = time().'_'.$request->image->extension();
        $imagePath = $request->image->move(public_path('images'), $imageName);
        
        $post->featured_image= $imagePath;

        $post->title = $request->title;
        $post->user_id = $request->author;
        $post->content = $request->content;
        $post->category_id = $request->category;
        $post->save();

        $post->tags()->sync($request->tags);

        return redirect()->back()->with('message', 'Post published');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = new Post();
        $post = $post->find($id);
        if (empty($post)) {
            abort(404);
        } else {
            return view('post', ['post' => $post]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = new Post();
        $post = $post->where('id', $id)->first();
        if (empty($post)) {
            abort(404);
        } else {
            $categories = Category::get();
            $tags = Tag::get();
            $selectedTags = Post::find($id)->tags;
            return view('post/edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags, 'selectedTags' => $selectedTags]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'author' => 'required',
        //     'content' => 'required',
        //     'category' => 'required',
        //     'image'=>'mimes:jpeg,png,jpg,gif|max:2048'
        // ]);

        $post = new Post();
        // return $request->file('image')->getClientOriginalName();
        $imageName = time().'_'.$request->file('image')->getClientOriginalName();
        $request->image->move(public_path('images'), $imageName);
        
        // $post->featured_image= $imageName;

        $title = $request->title;
        $author = $request->author;
        $content = $request->content;
        $category = $request->category;

        $post->where('id', $id)->update([
            'title' => $title,
            'user_id' => $author,
            'content' => $content,
            'category_id' => $category,
            'featured_image' => $imageName
        ]);

        if (isset($request->tags)) {
            Post::find($id)->tags()->sync($request->tags);
        } else {
            Post::find($id)->tags()->sync(array());
        }

        return redirect()->back()->with('message', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        return [
            'message' => 'Successfully Deleted'
        ];
    }
}
