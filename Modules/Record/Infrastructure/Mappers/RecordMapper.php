<?php

namespace Modules\Record\Infrastructure\Mappers;

use Modules\Record\Domain\Entities\Record as RecordEntity;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;

class RecordMapper
{
    public static function toArray(RecordEntity $record): array
    {
        $data = [
            'title'          => $record->getTitle(),
            'reference_date' => $record->getReferenceDate(),
            'value'          => $record->getValue(),
            'description'    => $record->getDescription(),
            'status'         => $record->getStatus(),
            'user_id'        => $record->getUserId(),
            'username'       => $record->getUsername(),
        ];

        if ($record->getId()) {
            $data['id'] = $record->getId();
        }

        return $data;
    }

    public static function toEntity(RecordModel $model): RecordEntity
    {
        return new RecordEntity(
            id: $model->id,
            title: $model->title,
            referenceDate: $model->reference_date,
            value: (float) $model->value,
            description: $model->description,
            status: $model->status,
            userId: $model->user_id,
            username: $model->user?->name
        );
    }

    public static function toResponse(RecordEntity $record): array
    {
        return [
            'id'             => $record->getId(),
            'title'          => $record->getTitle(),
            'reference_date' => $record->getReferenceDate(),
            'value'          => $record->getValue(),
            'description'    => $record->getDescription(),
            'status'         => $record->getStatus(),
            'user_id'        => $record->getUserId(),
            'username'       => $record->getUsername()
        ];
    }
}
