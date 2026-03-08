<?php

namespace Modules\Collaborator\Application\UseCases;

use Modules\Collaborator\Application\DTOs\CollaboratorCreateDTO;
use Modules\Collaborator\Domain\Entities\Collaborator;
use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;
use Modules\Collaborator\Infrastructure\Mappers\CollaboratorMapper;

class RegisterCollaborator
{
    public function __construct(private CollaboratorRepositoryInterface $collaboratorRepository) {}

    public function execute(CollaboratorCreateDTO $dto): Collaborator
    {

        $collaborator = CollaboratorMapper::fromDTO($dto);

        return $this->collaboratorRepository->save($collaborator);
    }
}
