<?php

namespace Modules\Core\Infrastructure\Services\File\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Domain\Services\File\Domain\File;
use Modules\Core\Domain\Services\File\Repositories\FileServiceInterface;
use Modules\Core\Infrastructure\Services\File\Jobs\DeleteFilesFromStorage;
use Modules\Core\Infrastructure\Services\File\Persistence\Eloquent\AttachmentModel;

class EloquentAttachmentRepository implements FileServiceInterface
{
    public function store(mixed $file, string $folder): File
    {
        if (!$file instanceof UploadedFile) {
            throw new \InvalidArgumentException("Tipo de arquivo não suportado.");
        }

        $disk = 'public';
        $mimeType = $file->getMimeType();
        $fileName = $file->getClientOriginalName();
        $fileSize = (int) $file->getSize();

        $allowedMimes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];

        if (in_array($mimeType, $allowedMimes)) {
            $newFileName = pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
            $path = $folder . '/' . $newFileName;

            $image = match ($mimeType) {
                'image/jpg' => @imagecreatefromjpeg($file->getRealPath()),
                'image/jpeg' => @imagecreatefromjpeg($file->getRealPath()),
                'image/png'  => @imagecreatefrompng($file->getRealPath()),
                'image/webp' => @imagecreatefromwebp($file->getRealPath()),
                default => null
            };

            if ($image) {
                ini_set('memory_limit', config('app.image_memory_limit', '128M'));

                ob_start();

                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);

                imagewebp($image, null, 80);
                $content = ob_get_clean();

                imagedestroy($image);

                if (!Storage::disk($disk)->exists($folder)) {
                    Storage::disk($disk)->makeDirectory($folder);
                }

                Storage::disk($disk)->put($path, $content);

                $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '.webp';
                $fileSize = strlen($content);
                $mimeType = 'image/webp';
            } else {
                $path = $file->store($folder, $disk);
            }
        } else {
            $path = $file->store($folder, $disk);
        }

        return new File(
            id: null,
            name: $fileName,
            path: $path,
            mime: $mimeType,
            size: $fileSize,
            disk: $disk,
            userId: auth()->id() ?? 0
        );
    }

    public function createAttachment(int $ownerId, string $ownerType, File $file): File
    {
        $actualClass = Relation::getMorphedModel($ownerType);

        if (!$actualClass) {
            throw new \InvalidArgumentException("Tipo de anexo inválido.");
        }

        $owner = $actualClass::findOrFail($ownerId);

        $model = $owner->attachments()->create([
            'name'    => $file->name,
            'path'    => $file->path,
            'mime'    => $file->mime,
            'size'    => $file->size,
            'disk'    => $file->disk,
            'user_id' => $file->userId,
        ]);

        return new File(
            id: $model->id,
            name: $model->name,
            path: $model->path,
            mime: $model->mime,
            size: $model->size,
            disk: $model->disk,
            userId: $model->user_id
        );
    }

    public function delete(string $path, string $disk = 'public'): bool
    {
        DeleteFilesFromStorage::dispatch($path, $disk);
        return true;
    }

    public function deleteAttachment(int $id): void
    {
        $register = AttachmentModel::find($id);
        if ($register) {
            $register->delete();
        }
    }

    public function findById(int $id): ?File
    {
        $model = AttachmentModel::find($id);

        if (!$model) {
            return null;
        }

        return new File(
            id: $model->id,
            name: $model->name,
            path: $model->path,
            mime: $model->mime,
            size: $model->size,
            disk: $model->disk,
            userId: $model->user_id
        );
    }
}
