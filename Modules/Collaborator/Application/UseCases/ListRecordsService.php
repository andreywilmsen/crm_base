<?php

namespace Modules\Collaborator\Application\UseCases;

use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;
use Modules\Collaborator\Infrastructure\Presenters\CollaboratorTablePresenter;

class ListRecordsService
{
    public function __construct(
        private CollaboratorTablePresenter $presenter,
        private CollaboratorRepositoryInterface $repository,
    ) {}

    public function execute(): array
    {
        $query = $this->repository->getQueryBuilder();

        return $this->presenter->render($query);
    }
}
