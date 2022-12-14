<?php

namespace App\Providers;

use App\Events\CreatePageEvent;
use App\Listeners\CreatePageListener;
//use App\Listeners\PageEventSubscriber;
use App\Models\Page;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UserReferred;
use App\Listeners\RewardUser;
use App\Listeners\CreateWalletsAfterRegister;

class EventServiceProvider extends ServiceProvider {
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateWalletsAfterRegister::class,
        ],
        UserReferred::class => [
            RewardUser::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {
        parent::boot();
        // ...
    }
}
