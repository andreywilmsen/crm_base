<?php

namespace Modules\Record\Infrastructure\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Record\Domain\Repositories\RecordCategoryRepositoryInterface;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use Modules\Record\Infrastructure\Repositories\EloquentRecordCategoryRepository;
use Modules\Record\Infrastructure\Repositories\EloquentRecordRepository;

class RecordServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RecordRepositoryInterface::class, EloquentRecordRepository::class);
        $this->app->bind(RecordCategoryRepositoryInterface::class, EloquentRecordCategoryRepository::class);
    }
    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'record');
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');
        $this->registerRoutes();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('funcionario'))) {
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
