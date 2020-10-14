<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function index()
    {

        if (Gate::allows('isAdmin') || Gate::allows('isEditor')) {

            $posts = Post::get();
            // $notifications = auth()->user()->unreadNotifications;

            return view('admin/dashboard')->with(compact("posts"));

        } else {

            $currentuser = Auth::user();

            $posts = Post::where('user_id', '=', $currentuser->id)->get();

            return view('admin/dashboard')->with(compact("posts"));
        }
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
