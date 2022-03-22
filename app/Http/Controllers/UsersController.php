<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
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
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }else {
                return back()->withErrors(['上传图片格式只支持png, jpg, gif, jpeg这四种格式']);
            }
        }

        $user->update($data);
        return redirect()->route('users.show',$user)->with('success','个人资料更新成功！');
    }
}
