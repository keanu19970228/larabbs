<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    // 展示用户个人中心页
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    // 展示用户编辑页面
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    // 编辑用户
    // UserRequest: 表单验证
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show',$user)->with('success','个人资料更新成功！');
    }
}
