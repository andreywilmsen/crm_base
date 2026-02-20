<?php

namespace Modules\Record\Infrastructure\Mappers;

use Modules\Record\Domain\Entities\RecordCategory as Entity;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;

class RecordCategoryMapper
{
    public static function toArray(Entity $entity): array
    {
        $data = [
            'name' => $entity->getName(),
        ];

        if ($entity->getId()) {
            $data['id'] = $entity->getId();
        }

        return $data;
    }

    public static function toEntity(RecordCategoryModel $model): Entity
    {
        return new Entity(
            id: $model->id,
            name: $model->name,
            createdAt: $model->created_at,
            updatedAt: $model->updated_at
        );
    }

    public static function toResponse(Entity $entity): array
    {
        return [
            'id'   => $entity->getId(),
            'name' => $entity->getName(),
        ];
    }
}
