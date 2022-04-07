<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicsTableSeeder extends Seeder
{
//因为创建时触发了模型事件，也就是我们的 TopicObserver.php 里 saved() 方法，这里执行 TranslateSlug 类，会实时请求百度的翻译接口，造成很大的延迟,用来调过延时 Model ;
    use WithoutModelEvents;

    public function run()
    {
        Topic::factory()->count(100)->create();
    }
}

