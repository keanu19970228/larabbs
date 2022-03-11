<?php

namespace App\Providers;

use App\Events\UsersLogin;
use App\Listeners\EmailVerified;
use App\Listeners\PasswordResetNotification;
use App\Listeners\UsersLoginNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        //  对 Registered 事件进行监听
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        //  对 Verified 事件进行监听
        Verified::class => [
            EmailVerified::class,
        ],
        //  对退出登陆 UsersLogout 事件进行监听
        UsersLogin::class => [
            UsersLoginNotification::class,
        ],
//        //  对重置密码 PasswordReset 事件进行监听
//        PasswordReset::class => [
//            PasswordResetNotification::class,
//        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
