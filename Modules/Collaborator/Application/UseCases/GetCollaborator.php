<?php

namespace Modules\Collaborator\Application\UseCases;

use InvalidArgumentException;
use Modules\Collaborator\Application\DTOs\CollaboratorResponseDTO;
use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;

class GetCollaborator
{
    public function __construct(private CollaboratorRepositoryInterface $collaboratorRepository) {}

    public function execute(int $id): CollaboratorResponseDTO
    {
        $collaborator = $this->collaboratorRepository->findByIdForResponse($id);

        if (!$collaborator) {
            throw new InvalidArgumentException('Colaborador não encontrado.');
        }

        return $collaborator;
    }
}
