<?php

namespace App\Providers;

use App\Services\Implements\MailService;
use App\Services\Implements\OTPService;
use App\Services\Interfaces\IMailService;
use App\Services\Interfaces\IOTPService;
use Illuminate\Support\ServiceProvider;

class ServiceLayerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            IMailService::class,
            MailService::class
        );
        $this->app->singleton(
            IOTPService::class,
            OTPService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
