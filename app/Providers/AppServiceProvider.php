<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
	    User::observe(UserObserver::class);
	    Topic::observe(TopicObserver::class);
	    Reply::observe(ReplyObserver::class);
	    Paginator::useBootstrap();

	    // 判断 categories 表是否存在
	    if( Schema::hasTable('categories') ) {
	        // 视图共享
	        View::share('categories', Category::all());
        }
    }
}
