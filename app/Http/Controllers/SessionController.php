<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => 'create'
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            //检查是否激活
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来');
                return redirect()->route('users.show', [Auth::user()]);
            } else {
                Auth::logout();
                session()->flash('warning', '您的账号尚未激活，请查看您的注册邮箱');
                return redirect('/');
            }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '你已经成功退出啦～');
        return redirect('login');
    }


}
