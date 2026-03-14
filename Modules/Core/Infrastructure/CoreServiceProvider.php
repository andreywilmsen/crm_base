<?php

namespace Modules\Core\Infrastructure;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Infrastructure\User\Providers\UserServiceProvider;
use Modules\Core\Infrastructure\Account\Providers\AccountServiceProvider;
use Modules\Core\Infrastructure\Services\File\Providers\FileServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AccountServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(FileServiceProvider::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'core');
        Blade::componentNamespace('Modules\\Core\\Resources\\Views\\Components', 'core');
    }
}
