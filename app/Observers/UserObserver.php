<?php

namespace App\Observers;

use App\Models\User;

// 模型观察器：Eloquent 观察器允许我们对给定模型中进行事件监控，观察者类里的方法名对应 Eloquent 想监听的事件。
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }
}
