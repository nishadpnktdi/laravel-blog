<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::get();
        $categories = Category::withCount('posts')->get();
        $posts = Post::with('user', 'category')->latest()->paginate(6);
        $latest = Post::limit(5)->latest()->get();
        return view('blog')->with(compact("posts", "categories", "tags", "latest"));
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
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post();

        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->image->move(public_path('images'), $imageName);

        $post->featured_image = $imageName;

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
        $post = $post->with('user')->find($id);
        $latest = Post::limit(5)->latest()->get();
        $tags = Tag::get();
        $categories = Category::withCount('posts')->get();

        //Next and Previous Post
        $next = Post::where('id', '>', $post->id)->oldest('id')->first();
        $prev = Post::where('id', '<', $post->id)->latest('id')->first();
        //End Next and Previous Post

        if (empty($post)) {
            abort(404);
        } else {
            return view('post')->with(compact('post', 'tags', 'categories', 'latest', 'next', 'prev'));
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
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'content' => 'required',
            'category' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post();

        $title = $request->title;
        $author = $request->author;
        $content = $request->content;
        $category = $request->category;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);

            $post->where('id', $id)->update([
                'title' => $title,
                'user_id' => $author,
                'content' => $content,
                'category_id' => $category,
                'featured_image' => $imageName
            ]);
        }

        $post->where('id', $id)->update([
            'title' => $title,
            'user_id' => $author,
            'content' => $content,
            'category_id' => $category,
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
            'message' => 'Post Deleted',
            'post_count' => Post::count()
        ];
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $query = $request->search;
        
        $keyword = $request->search;
        $latest = Post::limit(5)->latest()->get();
        $tags = Tag::get();
        $categories = Category::withCount('posts')->get();

        $results = Post::search($query)->paginate(6);

        return view('search', compact('results','keyword', 'latest', 'tags', 'categories'));
    }
}
