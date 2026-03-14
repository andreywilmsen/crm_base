<?php

namespace Modules\Core\Infrastructure\Services\File\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Domain\Services\File\Repositories\FileServiceInterface;
use Modules\Core\Infrastructure\Services\File\Repositories\EloquentAttachmentRepository;

class FileServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(
            FileServiceInterface::class,
            EloquentAttachmentRepository::class
        );
    }

    public function boot(): void
    {
        $basePath = dirname(__DIR__);
        $routePath = $basePath . '/Routes/web.php';
        $this->loadMigrationsFrom($basePath . '/Database/Migrations');
        if (file_exists($routePath)) {
            $this->loadRoutesFrom($routePath);
        }
    }
}
