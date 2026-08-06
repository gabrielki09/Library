<?php

namespace App\Providers;

use App\Repositories\Eloquent\Author\AuthorRepository;
use App\Repositories\Eloquent\Book\BookRepository;
use App\Repositories\Interfaces\Author\AuthorInterfaceRepository;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthorInterfaceRepository::class,
            AuthorRepository::class,

            BookInterfaceRepository::class,
            BookRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
