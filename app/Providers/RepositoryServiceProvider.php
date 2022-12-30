<?php
namespace App\Providers;

use App\Repositories\Implementations\BaseRepository;
use App\Repositories\Implementations\ConversationRepository;
use App\Repositories\Implementations\MemberRepository;
use App\Repositories\Implementations\MessagesRepository;
use App\Repositories\Implementations\RelationshipRepository;
use App\Repositories\Implementations\UserRepository;
use App\Repositories\Interfaces\IConversationRepository;
use App\Repositories\Interfaces\IMemberRepository;
use App\Repositories\Interfaces\IMessagesRepository;
use App\Repositories\Interfaces\IRelationshipRepository;
use App\Repositories\Interfaces\IRepository;
use App\Repositories\Interfaces\IUserRepository;
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
        $this->app->singleton(
            IUserRepository::class,
            UserRepository::class
        );
        $this->app->singleton(
            IConversationRepository::class,
            ConversationRepository::class
        );
        $this->app->singleton(
            IMemberRepository::class,
            MemberRepository::class
        );
        $this->app->singleton(
            IMessagesRepository::class,
            MessagesRepository::class
        );
        $this->app->singleton(
            IRelationshipRepository::class,
            RelationshipRepository::class
        );
    }

    public function boot()
    {

    }
}
