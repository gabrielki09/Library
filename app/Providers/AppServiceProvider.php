<?php

namespace App\Providers;

use App\Repositories\Eloquent\Author\AuthorRepository;
use App\Repositories\Eloquent\Book\BookLoanRepository;
use App\Repositories\Eloquent\Book\BookRepository;
use App\Repositories\Eloquent\Reader\ReaderRepository;
use App\Repositories\Interfaces\Author\AuthorInterfaceRepository;
use App\Repositories\Interfaces\Book\BookInterfaceRepository;
use App\Repositories\Interfaces\Book\BookLoanInterfaceRepository;
use App\Repositories\Interfaces\Reader\ReaderInterfaceRepository;
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
        );

        $this->app->bind(
            BookInterfaceRepository::class,
            BookRepository::class
        );

        $this->app->bind(
            ReaderInterfaceRepository::class,
            ReaderRepository::class
        );

        $this->app->bind(
            BookLoanInterfaceRepository::class,
            BookLoanRepository::class
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
