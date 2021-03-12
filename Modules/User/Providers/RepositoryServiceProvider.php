<?php

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Repositories\DocumentRepository;
use Modules\User\Repositories\Eloquent\EloquentDocumentRepository;
use Modules\User\Repositories\Eloquent\EloquentProfileRepository;
use Modules\User\Repositories\Eloquent\EloquentUserRepository;
use Modules\User\Repositories\ProfileRepository;
use Modules\User\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //   $this->app->bind('Modules\User\Repositories\ProfileRepository','Modules\User\Repositories\Eloquent\EloquentProfileRepository');
          $this->app->bind(ProfileRepository::class,EloquentProfileRepository::class);
          $this->app->bind(DocumentRepository::class,EloquentDocumentRepository::class);
          $this->app->bind(UserRepository::class,EloquentUserRepository::class);

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
