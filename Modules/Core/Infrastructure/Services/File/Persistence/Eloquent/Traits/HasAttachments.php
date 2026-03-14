<?php

namespace Modules\Core\Infrastructure\Services\File\Persistence\Eloquent\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Core\Infrastructure\Services\File\Persistence\Eloquent\AttachmentModel;

trait HasAttachments
{
    public function attachments(): MorphMany
    {
        return $this->morphMany(AttachmentModel::class, 'attachable');
    }
}
