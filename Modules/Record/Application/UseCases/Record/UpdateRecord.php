<?php

namespace Modules\Record\Application\UseCases\Record;

use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use InvalidArgumentException;
use Modules\Core\Application\Services\File\UseCases\UploadAttachment;
use Modules\Record\Application\DTOs\Record\RecordUpdateDTO;
use Modules\Record\Infrastructure\Mappers\RecordMapper;

class UpdateRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository, private UploadAttachment $uploadAttachment) {}

    public function execute(RecordUpdateDTO $dto): Record
    {
        $existingRecord = $this->recordRepository->findById($dto->id);

        if (!$existingRecord) {
            throw new \InvalidArgumentException("Registro não encontrado.");
        }

        if ($dto->file) {
            $folder = Record::PATH_STORAGE . "/{$dto->id}";

            $this->uploadAttachment->execute($dto->id, 'record', $dto->file, $folder);
        }

        $updatedRecord = RecordMapper::fromDTO($dto);
        return $this->recordRepository->save($updatedRecord);
    }
}
