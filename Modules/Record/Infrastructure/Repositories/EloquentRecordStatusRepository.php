<?php

namespace Modules\Record\Infrastructure\Repositories;

use Modules\Record\Domain\Entities\RecordStatus as RecordStatusEntity;
use Modules\Record\Domain\Repositories\RecordStatusRepositoryInterface;
use Modules\Record\Infrastructure\Mappers\RecordStatusMapper;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordStatusModel;

class EloquentRecordStatusRepository implements RecordStatusRepositoryInterface
{
    public function __construct(
        private readonly RecordStatusModel $model
    ) {}

    public function findAll(): array
    {
        return $this->model->all()
            ->map(fn($model) => RecordStatusMapper::toEntity($model))
            ->all();
    }

    public function findById(int $id): ?RecordStatusEntity
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        return RecordStatusMapper::toEntity($model);
    }

    public function save(RecordStatusEntity $status): RecordStatusEntity
    {
        $data = RecordStatusMapper::toArray($status);

        $model = $this->model->updateOrCreate(
            ['id' => $status->getId()],
            $data
        );

        return RecordStatusMapper::toEntity($model);
    }

    public function delete(RecordStatusEntity $status): void
    {
        $this->model->destroy($status->getId());
    }
}
