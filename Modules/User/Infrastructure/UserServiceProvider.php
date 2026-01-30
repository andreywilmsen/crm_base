<?php

namespace Modules\user\infrastructure;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class UserServiceProvider extends ServiceProvider
{
    public function register() {}
    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'user');
        $this->registerRoutes();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'text' => 'Usuários',
                'icon' => 'fas fa-fw fa-users',
                'route' => 'users.index',
            ]);
        });
    }
    public function registerRoutes()
    {
        Route::midleware('web')->group(__DIR__ . '/Routes/web.php');
    }
}