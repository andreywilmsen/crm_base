<?php

namespace Modules\Collaborator\Application\UseCases\Collaborator;

use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;

class GetAllCollaborators
{
    public function __construct(private CollaboratorRepositoryInterface $collaboratorRepository) {}

    public function execute(): array
    {
        return $this->collaboratorRepository->findAll();
    }
}
