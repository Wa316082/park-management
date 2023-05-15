<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //user show
    public function index()
    {
        if(Auth::user()->role->name != 'Admin')
        {
            return redirect()->route('home');
        }
        $users = User::get();
        return view('users.index', compact('users'));
    }


    //user create
    public function create()
    {
        if(Auth::user()->role->name != 'Admin')
        {
            return redirect()->route('home');
        }
        return view('users.user_create');
    }


    //user store
    public function store(Request $request)
    {

        if(Auth::user()->role->name != 'Admin')
        {
            return redirect()->route('home');
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password= Hash::make($request->password);

            $user->save();
            return redirect()->route('users')->with('success','User has been created');

        } catch (Throwable $th) {
           return $th;
        }
    }


    // user edit
    public function edit($id)
    {
        if(Auth::user()->role->name != 'Admin')
        {
            return redirect()->route('home');
        }
        $user= User::find($id);
        return view('users.user_edit', compact('user'));
    }


    // user edit
    public function update(Request $request)
    {
        if(Auth::user()->role->name != 'Admin')
        {
            return redirect()->route('home');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $request->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'current_password'=>['required','string'],
        ]);
        $user = User::find($request->id);
        if(!Hash::check($request->current_password,$user->password )){
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->update();
            return redirect()->route('users')->with('success','User Updated Successfully');
        } catch (\Throwable $th) {
            return $th;
        }
    }


    public function delete($id)
    {
        if(Auth::user()->role->name != 'Admin')
        {
            return redirect()->route('home');
        }

        $user = User::find($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'User Deleted Successfully');
    }
}
