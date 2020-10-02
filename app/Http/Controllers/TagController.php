<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::get();
        return view('/tag/create')->with('tags', $tags);
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
            'name'      => 'required|min:3|max:255|string|unique:tags'
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();

        return redirect()->route('tag.create')->with('message','Tag created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tags = Tag::get();
        $categories = Category::withCount('posts')->get();
        $posts = Post::whereHas('tags', function ($query) use ($id) {
            return $query->where('id', $id);
        })->latest()->paginate(6);
        $latest = Post::limit(5)->latest()->get();
        $tag = Tag::find($id);
        return view('tag/tag')->with(compact("tag", "posts", "categories", "tags", "latest"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request, [
            'name'  => 'required|min:3|max:255|string|unique:tags'
        ]);
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->name = $validatedData['name'];
        $tag->save();

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('isAdmin')) {
            $tag = Tag::find($id);

            $tag->delete();

            return [
                'message' => 'Tag Deleted',
                'tag_count' => Tag::count()
            ];
        }
        return back()->with('message', "You're not Authorized!");
    }
}
