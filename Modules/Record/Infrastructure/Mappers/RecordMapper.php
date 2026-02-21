<?php

namespace Modules\Record\Infrastructure\Mappers;

use Modules\Record\Application\DTOs\Record\RecordResponseDTO;
use Modules\Record\Domain\Entities\Record as RecordEntity;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;

class RecordMapper
{
    public static function toArray(RecordEntity $record): array
    {
        return [
            'id'             => $record->getId(),
            'title'          => $record->getTitle(),
            'reference_date' => $record->getReferenceDate(),
            'value'          => $record->getValue(),
            'description'    => $record->getDescription(),
            'status_id'      => $record->getStatusId(),
            'category_id'    => $record->getCategoryId(),
            'user_id'        => $record->getUserId(),
        ];
    }

    public static function toEntity(RecordModel $model): RecordEntity
    {
        return new RecordEntity(
            id: $model->id,
            title: $model->title,
            referenceDate: $model->reference_date,
            value: (float) $model->value,
            description: $model->description,
            statusId: $model->status_id,
            userId: $model->user_id,
            categoryId: $model->category_id
        );
    }

    public static function toResponseDTO(mixed $data): RecordResponseDTO
    {
        $isModel = $data instanceof RecordModel;

        return new RecordResponseDTO(
            id: $isModel ? (int) $data->id : (int) $data->getId(),
            title: $isModel ? $data->title : $data->getTitle(),
            referenceDate: $isModel ? $data->reference_date : $data->getReferenceDate(),
            value: $isModel ? (float) $data->value : $data->getValue(),
            description: $isModel ? $data->description : $data->getDescription(),
            statusId: $isModel ? $data->status_id : $data->getStatusId(),
            statusName: $isModel ? ($data->status?->name ?? 'N/A') : 'N/A',
            categoryId: $isModel ? $data->category_id : $data->getCategoryId(),
            categoryName: $isModel ? ($data->category?->name ?? 'N/A') : 'N/A',
            userId: $isModel ? $data->user_id : $data->getUserId(),
            username: $isModel ? ($data->user?->name ?? 'N/A') : 'N/A'
        );
    }
}
