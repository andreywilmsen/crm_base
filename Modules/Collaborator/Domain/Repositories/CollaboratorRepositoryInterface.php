<?php

namespace Modules\Collaborator\Domain\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Collaborator\Application\DTOs\CollaboratorResponseDTO;
use Modules\Collaborator\Domain\Entities\Collaborator;

interface CollaboratorRepositoryInterface
{
    public function save(Collaborator $collaborator): Collaborator;

    public function delete(Collaborator $collaborator): void;

    public function findById(int $id): ?Collaborator;

    public function findByIdForResponse(int $id): ?CollaboratorResponseDTO;

    public function findByName(string $name): ?Collaborator;

    public function findAll(): array;

    public function getQueryBuilder(): Builder;
}
