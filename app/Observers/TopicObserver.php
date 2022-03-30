<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// 模型观察器：Eloquent 观察器允许我们对给定模型中进行事件监控，观察者类里的方法名对应 Eloquent 想监听的事件。

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    // 如果一个模型已经存在于数据库且调用了 save 方法，将会触发 updating 和 updated 事件。在这两种情况下都会触发 saving 和 saved 事件。
    public function saving(Topic $topic)
    {
        // 在观察这种对富文本输入的 body 字段进行 XSS 过滤
        // https://learnku.com/courses/laravel-intermediate-training/9.x/safety-problem/12512
        $topic->body = clean($topic->body,'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (! $topic->slug) {

            // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}
