<?php

namespace Modules\Record\Application\UseCases\Record;

use Modules\Record\Application\UseCases\RecordCategory\GetAllRecordsCategories;
use Modules\Record\Application\UseCases\RecordStatus\GetAllRecordsStatus;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use Modules\Record\Infrastructure\Presenters\RecordTablePresenter;

class ListRecordsService
{
    public function __construct(
        private RecordTablePresenter $presenter,
        private RecordRepositoryInterface $repository,
        private GetAllRecordsCategories $getCategories,
        private GetAllRecordsStatus $getStatus
    ) {}

    public function execute(): array
    {
        $query = $this->repository->getQueryBuilder();

        $options = [
            'categories' => $this->getCategories->execute(),
            'status'     => $this->getStatus->execute(),
        ];

        return $this->presenter->render($query, $options);
    }
}
