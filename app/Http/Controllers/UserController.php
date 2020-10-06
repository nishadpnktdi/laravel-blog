<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('/user/users')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed',
            ]);

            return User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('message', "You're not Authorized!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|confirmed',
            'role'     => 'required',
            'image'    => 'image|nullable'
        ]);

        $name     = $request->name;
        $email    = $request->email;
        $password = $request->password;
        $role     = $request->role;
        $image    = $request->image;

        if ($request->hasFile('image')) {
            return response('file here');
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

            $image->move(storage_path('profile-photos'), $imageName);

            $user->profile_photo_path = 'profile-photos/' + $imageName;

        }

        if (!$password == '') {
            if (!$email == '') {

                $user->email = $email;
            }

            $user->password = $password;
        }

        $user->email = $email;
        $user->name = $name;
        $user->role = $role;
        $user->save();
        return response('success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('isAdmin')) {
            $user = User::find($id);

            $user->delete();

            return [
                'message' => 'User Deleted',
                'user_count' => User::count()
            ];
        } else {
            return back()->with('message', "You're not Authorized!");
        }
    }
}
