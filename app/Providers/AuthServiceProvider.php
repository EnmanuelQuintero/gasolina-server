<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Event::listen(Login::class, function ($event) {
            DB::table('users')
                ->where('id', $event->user->id)
                ->update(['is_active' => 1]);
        });

        Event::listen(Logout::class, function ($event) {
            DB::table('users')
                ->where('id', $event->user->id)
                ->update(['is_active' => 0]);
        });
    }
}
