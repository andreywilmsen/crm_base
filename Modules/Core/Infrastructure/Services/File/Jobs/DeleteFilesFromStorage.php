<?php

namespace Modules\Core\Infrastructure\Services\File\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Tests\Traits\InteractsWithRoles;

class DeleteFilesFromStorage implements ShouldQueue
{
    use Dispatchable, InteractsWithRoles, Queueable, SerializesModels;

    public function __construct(
        private readonly string $path,
        private readonly string $disk = 'public'
    ) {}

    public function handle(): void
    {
        $storage = Storage::disk($this->disk);

        if ($storage->exists($this->path)) {
            $storage->delete($this->path);
        }
        $folder = dirname($this->path);

        if (!in_array($folder, ['.', 'uploads', 'public']) && $storage->exists($folder)) {

            $files = $storage->allFiles($folder);
            $subfolders = $storage->directories($folder);

            if (empty($files) && empty($subfolders)) {
                $storage->deleteDirectory($folder);
            }
        }
    }
}
