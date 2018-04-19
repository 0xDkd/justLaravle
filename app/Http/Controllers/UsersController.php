<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);
        $this->middleware('guest',[
            'only'=>'create'
        ]);
    }
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }


    public function create()
    {
        return view('users/create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开始一段新的旅程');
        return redirect()->route('users.show', [$user]);
    }

    public function update(User $user ,Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request,[
            'name'=> 'required|max:50',
            'password'=>'nullable|confirmed'
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','信息修成功～');
        return redirect()->route('users.edit',$user->id);
    }
}
