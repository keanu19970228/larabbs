<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        // 必须登录用户才能看到自己的通知~
        $this->middleware('auth');
    }

    public function index()
    {
        // 获取登录用户的所有通知
        $notifications = Auth::user()->notifications()->paginate(20);
        // 标记为已读，未读数清零
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
