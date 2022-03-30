<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
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
	    Paginator::useBootstrap();

		// 视图共享
		View::share('categories', Category::all());
    }
}
