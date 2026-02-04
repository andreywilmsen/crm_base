<?php

namespace Modules\Core\Infrastructure;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\User\Domain\Repositories\UserRepositoryInterface;
use Modules\User\Infrastructure\Repositories\EloquentUserRepository;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/Account/Views', 'account');

        $this->registerRoutes();

        $this->configureMenu($events);
    }

    protected function registerRoutes()
    {
        $path = __DIR__ . '/Account/Routes/web.php';

        if (file_exists($path)) {
            Route::middleware('web')
                ->prefix('admin')
                ->group($path);
        }
    }

    protected function configureMenu(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('funcionario'))) {

                $event->menu->add([
                    'text' => 'Meu perfil',
                    'icon' => 'fas fa-fw fa-user',
                    'route' => 'account.index',
                    'active' => ['admin/account*'],
                ]);
            }
        });
    }
}
