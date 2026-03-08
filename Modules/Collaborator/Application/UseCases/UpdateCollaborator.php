<?php

namespace Modules\Collaborator\Application\UseCases;

use Modules\Collaborator\Domain\Entities\Collaborator;
use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;
use InvalidArgumentException;
use Modules\Collaborator\Application\DTOs\CollaboratorUpdateDTO;
use Modules\Collaborator\Infrastructure\Mappers\CollaboratorMapper;

class UpdateCollaborator
{
    public function __construct(private CollaboratorRepositoryInterface $collaboratorRepository) {}

    public function execute(CollaboratorUpdateDTO $dto): Collaborator
    {
        $existingCollaborator = $this->collaboratorRepository->findById($dto->id);

        if (!$existingCollaborator) {
            throw new InvalidArgumentException("Colaborador com ID {$dto->id} não encontrado.");
        }

        $updatedCollaborator = CollaboratorMapper::fromDTO($dto);

        return $this->collaboratorRepository->save($updatedCollaborator);
    }
}
