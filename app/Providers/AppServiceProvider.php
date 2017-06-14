<?php

namespace App\Providers;

use App\Observers\PostObserver;
use App\Observers\ThreadObserver;
use Illuminate\Support\ServiceProvider;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', 'App\Http\Composers\MasterComposer');
        Thread::observe(ThreadObserver::class);
        Post::observe(PostObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
