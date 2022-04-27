<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// 模型观察器：Eloquent 观察器允许我们对给定模型中进行事件监控，观察者类里的方法名对应 Eloquent 想监听的事件。

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        // 预防 XSS 攻击
        $reply->content = clean($reply->content, 'user_topic_body');

        if (empty($reply->content)) {
            return false;
        }
    }

    public function updating(Reply $reply)
    {
        //
    }

    // 监控 created 事件，当 Elequont 模型数据成功创建时，created 方法将会被调用。
    public function created(Reply $reply)
    {
//        $reply->topic->increment('reply_count', 1);
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        // 通知话题作者有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }

}
