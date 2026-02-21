<?php

namespace Modules\Record\Application\UseCases\Record;

use InvalidArgumentException;
use Modules\Record\Application\DTOs\Record\RecordResponseDTO;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;

class GetRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(int $id): RecordResponseDTO
    {
        $record = $this->recordRepository->findByIdForResponse($id);

        if (!$record) {
            throw new InvalidArgumentException('Registro não encontrado.');
        }

        return $record;
    }
}
