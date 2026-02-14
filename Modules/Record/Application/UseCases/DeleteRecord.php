<?php

namespace Modules\Record\Application\UseCases;

use InvalidArgumentException;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;

class DeleteRecord
{
    public function __construct(private RecordRepositoryInterface $recordRepository) {}

    public function execute(int $id): void
    {
        $user = $this->recordRepository->findById($id);

        if (!$user) {
            throw new InvalidArgumentException('Registro não encontrado.');
        }

        $this->recordRepository->delete($user);
    }
}
