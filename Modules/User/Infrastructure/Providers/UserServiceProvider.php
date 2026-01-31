<?php

namespace Modules\User\Infrastructure\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\User\Domain\Repositories\UserRepositoryInterface;
use Modules\User\Infrastructure\Repositories\EloquentUserRepository;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }
    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'user');
        $this->registerRoutes();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'text' => 'Usuários',
                'icon' => 'fas fa-fw fa-users',
                'route' => 'user.index',
            ]);
        });
    }
    public function registerRoutes()
    {
        $path = __DIR__ . '/../Routes/web.php';

        if (file_exists($path)) {
            Route::middleware('web')
                ->prefix('admin')
                ->group($path);
        }
    }
}
