<?php

namespace Modules\Record\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Record\Domain\Entities\RecordCategory as RecordCategoryEntity;
use Modules\Record\Domain\Repositories\RecordCategoryRepositoryInterface;
use Modules\Record\Infrastructure\Mappers\RecordCategoryMapper;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;

class EloquentRecordCategoryRepository implements RecordCategoryRepositoryInterface
{
    public function __construct(
        private readonly RecordCategoryModel $model
    ) {}

    public function findAll(): array
    {
        return $this->model->all()
            ->map(fn($model) => RecordCategoryMapper::toEntity($model))
            ->all();
    }

    public function findById(int $id): ?RecordCategoryEntity
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        return RecordCategoryMapper::toEntity($model);
    }

    public function save(RecordCategoryEntity $category): RecordCategoryEntity
    {
        return DB::transaction(function () use ($category) {
            $data = RecordCategoryMapper::toArray($category);

            $model = $this->model->updateOrCreate(
                ['id' => $category->getId()],
                $data
            );

            return RecordCategoryMapper::toEntity($model);
        });
    }

    public function delete(RecordCategoryEntity $category): void
    {
        $this->model->destroy($category->getId());
    }
}
