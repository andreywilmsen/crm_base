<?php

namespace Modules\Collaborator\Infrastructure\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;
use Modules\Collaborator\Infrastructure\Repositories\EloquentCollaboratorRepository;

class CollaboratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CollaboratorRepositoryInterface::class, EloquentCollaboratorRepository::class);
    }

    public function boot(Dispatcher $events)
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'collaborator');
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');
        $this->registerRoutes();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->check() && (auth()->user()->hasRole('admin'))) {
                $event->menu->add([
                    'text'   => 'Colaboradores',
                    'icon'   => 'fas fa-fw fa-users',
                    'route'  => 'collaborator.index',
                    'active' => ['collaborator*'],
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
