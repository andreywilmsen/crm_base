<?php

namespace Modules\Core\Infrastructure\Services\File\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AttachmentModel extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'name',
        'path',
        'mime',
        'size',
        'disk',
        'user_id',
        'attachable_id',
        'attachable_type'
    ];

    protected $appends = ['url'];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        /** @var Filesystem $storage */
        $storage = Storage::disk($this->disk);

        return $storage->url($this->path);
    }
}
