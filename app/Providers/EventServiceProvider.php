<?php

namespace App\Providers;

use App\Events\UserRegistration;
use App\Listeners\TelegramSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendRegistrationEmailMessage;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistration::class => [
            SendRegistrationEmailMessage::class,
        ],
        // 'Illuminate\Auth\Events\Verified' => [
        //     'App\Listeners\LogVerifiedUser',
        // ],
    ];

    protected $subscribe = [
        TelegramSubscriber::class
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
