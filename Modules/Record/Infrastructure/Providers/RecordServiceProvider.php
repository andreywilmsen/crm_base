<?php

namespace Modules\Record\Infrastructure\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Record\Domain\Repositories\RecordRepositorieInterface;
use Modules\Record\Infrastructure\Repositories\EloquentRecordRepositories;

class RecordServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RecordRepositorieInterface::class, EloquentRecordRepositories::class);
    }
    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'record');
        $this->registerRoutes();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->check() && auth()->user()->hasRole('admin')) {
                $event->menu->add([
                    'text' => 'Registros',
                    'icon' => 'fas fa-fw fa-file',
                    'route' => 'record.index',
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
