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
        // $user->notifications()->get() // 获取所有的通知
        // $user->readNotifications()->get() // 获取已读
        // $user->unreadNotifications()->get() // 获取未读
        // $user->unreadNotifications->markAsRead() // 将未读标记为已读
        // $user->readNotifications->markAsUnread() // 将已读标记为未读
        $notifications = Auth::user()->notifications()->paginate(20);
        // 标记为已读，未读数清零
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
