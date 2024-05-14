<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Contracts\AdminInterface', 'App\Repositories\AdminRepository');
        $this->app->bind('App\Contracts\CmsInterface', 'App\Repositories\CmsRepository');
        $this->app->bind('App\Contracts\CategoryInterface', 'App\Repositories\CategoryRepository');
        $this->app->bind('App\Contracts\ProductInterface', 'App\Repositories\ProductRepository');

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
