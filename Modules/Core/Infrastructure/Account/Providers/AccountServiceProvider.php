<?php

namespace Modules\Core\Infrastructure\Account\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AccountServiceProvider extends ServiceProvider
{
    public function register(){}

    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'account');

        $this->registerRoutes();
        
        $this->registerMenu($events);
    }

    protected function registerRoutes()
    {
        $path = __DIR__ . '/../Routes/web.php';

        if (file_exists($path)) {
            Route::middleware('web')
                ->prefix('admin')
                ->group($path);
        }
    }

    protected function registerMenu(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $user = auth()->user();
            
            // Menu visível para Admin e Funcionário
            if ($user && ($user->hasRole('admin') || $user->hasRole('funcionario'))) {
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