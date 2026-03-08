<?php

namespace Modules\Collaborator\Application\UseCases;

use InvalidArgumentException;
use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;

class DeleteCollaborator
{
    public function __construct(private CollaboratorRepositoryInterface $collaboratorRepository) {}

    public function execute(int $id): void
    {
        $user = $this->collaboratorRepository->findById($id);

        if (!$user) {
            throw new InvalidArgumentException('Colaborador não encontrado.');
        }

        $this->collaboratorRepository->delete($user);
    }
}
