<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    // 展示用户个人中心页
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
