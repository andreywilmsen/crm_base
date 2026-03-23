<?php

namespace Modules\Core\Infrastructure\Services\File\Validators;

use Illuminate\Http\UploadedFile;

class FileValidator
{
    public static function hasValidMime(UploadedFile $file, array $allowedMimes): bool
    {
        $path = $file->getRealPath();

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($path);

        return in_array($realMime, $allowedMimes);
    }
}
