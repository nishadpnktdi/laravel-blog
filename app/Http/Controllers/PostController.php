<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\GalleryImage;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

use function GuzzleHttp\json_decode;

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
        $notifications = auth()->user()->unreadNotifications;
        return view('post/create')->with(compact("categories", "tags", "notifications"));
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
            // 'image' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        $post = new Post();

        if (isset($request->image)) {

            $some = json_decode($request->image);
            $imgDecodedName = $some->name;
            $imageName = time() . '_' . $imgDecodedName;
            // $decoded_image = Image::make($some->data)->resize(700, 450);s
            // $savedImage = $decoded_image->save(public_path('images/') . $imageName);
            $post->addMediaFromBase64($some->data)->toMediaCollection('featuredImage');
            $post->featured_image = $imageName;
        }

        if (isset($request->gallery)) {
            $imgNames = [];
            foreach ($request->gallery as $image) {
                $some = json_decode($image);
                $dat = $some->name;
                $imageName = time() . '_' . $dat;
                // $decoded_image = Image::make($some->data)->resize(700, 450);
                // $decoded_image->save(public_path('images/') . $imageName);
                $post->addMediaFromBase64($some->data)->toMediaCollection('gallery');
                // array_push($imgNames, $imageName);
            }
            // $image = new GalleryImage();
            // $image->image = json_encode($imgNames);
            // $post->images_id = $image->id;
        }


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

        // $images_id = Post::find($id)->images_id;
        // $grabbed_img_array = GalleryImage::find($images_id);
        // if ($grabbed_img_array == null) {
        //     $img_list = [];
        // } else {
        //     $img_list = $grabbed_img_array['image'];
        // }

        
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
            $images_id = Post::find($id)->images_id;
            $grabbed_img_array = GalleryImage::find(1);
            $notifications = auth()->user()->unreadNotifications;

            if ($grabbed_img_array !== null) {

                $img_list = $grabbed_img_array['image'];
                return view('post/edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags, 'selectedTags' => $selectedTags, 'notification' => $notifications]);
            } else {

                return view('post/edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags, 'selectedTags' => $selectedTags, 'notifications' => $notifications]);
            }
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

        // dd($img);
        $request->validate([
            'title'    => 'required',
            'author'   => 'required',
            'content'  => 'required',
            'category' => 'required',
            // 'image'    => 'sometimes',
            // 'image.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'gallery'    => 'sometimes',
            // 'gallery.*'    => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $post = Post::find($id);
        // $gallery = new GalleryImage;

        $post->title    = $request->title;
        $post->user_id  = $request->author;
        $post->content  = $request->content;
        $post->category_id = $request->category;

        if (isset($request->image)) {

            $some = json_decode($request->image);
            $imgDecodedName = $some->name;
            $imageName = time() . '_' . $imgDecodedName;
            // $decoded_image = Image::make($some->data)->resize(700, 450);
            // $decoded_image->save(public_path('images/') . $imageName);
            $post->addMediaFromBase64($some->data)->toMediaCollection('featuredImage');
            $post->featured_image = $imageName;
        }

        if($request->gallery == null) {
            $post->clearMediaCollection('gallery');
        }

        if (isset($request->gallery)) {
            // $imgNames = [];
            $post->clearMediaCollection('gallery');
            foreach ($request->gallery as $image) {
                $some = json_decode($image);
                $dat = $some->name;
                $imageName = time() . '_' . $dat;
                // $decoded_image = Image::make($some->data)->resize(700, 450);
                // $decoded_image->save(public_path('images/') . $imageName);
                // $post->clearMediaCollection('gallery');
                $post->addMediaFromBase64($some->data)->toMediaCollection('gallery');
                // array_push($imgNames, $imageName);
            }
            // $image = new GalleryImage();
            // $image->image = json_encode($imgNames);
            // $gallery->save();
            // $post->images_id = $gallery->id;
        }
        $post->save();

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
        if (Gate::allows('isAdmin')) {
            $post = Post::find($id);

            $post->delete();

            return [
                'message' => 'Post Deleted',
                'post_count' => Post::count()
            ];
        } else {
            return back()->with('message', "You're not Authorized!");
        }
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

        return view('search', compact('results', 'keyword', 'latest', 'tags', 'categories'));
    }
}
