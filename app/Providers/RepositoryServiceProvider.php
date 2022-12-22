<?php
namespace App\Providers;

use App\Repositories\Implementations\BaseRepository;
use App\Repositories\Interfaces\IRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            IRepository::class,
            BaseRepository::class
        );
    }

    public function boot()
    {

    }
}
