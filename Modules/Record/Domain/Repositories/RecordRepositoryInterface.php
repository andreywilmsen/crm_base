<?php

namespace Modules\Record\Domain\Repositories;

use Modules\Record\Domain\Entities\Record;

interface RecordRepositoryInterface
{
    public function save(Record $record): Record;

    public function delete(Record $record): void;

    public function findById(int $id): ?Record;

    public function findByTitle(string $title): ?Record;

    public function findAll(): array;
}
