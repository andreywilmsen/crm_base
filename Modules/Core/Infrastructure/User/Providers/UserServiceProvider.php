<?php

namespace Modules\Core\Infrastructure\User\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Infrastructure\User\Repositories\EloquentUserRepository;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;


class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'user_module');
    }
    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'user');
        $this->registerRoutes();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->check() && auth()->user()->hasRole('admin')) {
                $event->menu->add([
                    'text' => 'Usuários',
                    'icon' => 'fas fa-fw fa-users',
                    'route' => 'user.index',
                ]);
            }
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
