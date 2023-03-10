<?php

namespace App\Providers;

use App\Http\Controllers\FriendController;
use App\Services\Implements\AccountService;
use App\Services\Implements\AuthService;
use App\Services\Implements\ConversationService;
use App\Services\Implements\FriendService;
use App\Services\Implements\JWTService;
use App\Services\Implements\MailService;
use App\Services\Implements\MessagesService;
use App\Services\Implements\OTPService;
use App\Services\Implements\RedisService;
use App\Services\Interfaces\IAccountService;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IConversationService;
use App\Services\Interfaces\IFriendService;
use App\Services\Interfaces\IJWTService;
use App\Services\Interfaces\IMailService;
use App\Services\Interfaces\IMessagesService;
use App\Services\Interfaces\IOTPService;
use App\Services\Interfaces\IRedisService;
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
            IAuthService::class,
            AuthService::class
        );
        $this->app->singleton(
            IJWTService::class,
            JWTService::class
        );
        $this->app->singleton(
            IMailService::class,
            MailService::class
        );
        $this->app->singleton(
            IOTPService::class,
            OTPService::class
        );
        $this->app->singleton(
            IRedisService::class,
            RedisService::class
        );
        $this->app->singleton(
            IAccountService::class,
            AccountService::class
        );
        $this->app->singleton(
            IFriendService::class,
            FriendService::class
        );
        $this->app->singleton(
            IConversationService::class,
            ConversationService::class
        );
        $this->app->singleton(
            IMessagesService::class,
            MessagesService::class
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
