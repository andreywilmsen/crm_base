<?php

namespace Modules\Core\Infrastructure\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Tests\Traits\InteractsWithRoles;

class DeleteFilesFromStorage implements ShouldQueue
{
    use Dispatchable, InteractsWithRoles, Queueable, SerializesModels;

    /**
     * @param string $path
     * @param string $disk
     */
    public function __construct(
        private readonly string $path,
        private readonly string $disk = 'public'
    ) {}

    public function handle(): void
    {
        if (Storage::disk($this->disk)->exists($this->path)) {
            Storage::disk($this->disk)->delete($this->path);
        }
    }
}
