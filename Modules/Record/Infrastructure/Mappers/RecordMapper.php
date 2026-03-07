<?php

namespace Modules\Record\Infrastructure\Mappers;

use Modules\Record\Application\DTOs\Record\RecordResponseDTO;
use Modules\Record\Domain\Entities\Record as RecordEntity;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;

class RecordMapper
{
    /**
     * Transforma Entidade em Array (Para o Eloquent salvar)
     */
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

    /**
     * Transforma Model em Entidade (Para a Lógica de Negócio)
     */
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

    /**
     * Transforma o Model direto para DTO de Resposta (Performance na Tabela)
     * Aqui tratamos os relacionamentos do Eloquent para as TableColumns
     */
    public static function toResponseDTO(RecordModel $model): RecordResponseDTO
    {
        return new RecordResponseDTO(
            id: (int) $model->id,
            title: $model->title,
            referenceDate: $model->reference_date,
            value: (float) $model->value,
            description: $model->description,
            statusId: (int) $model->status_id,
            statusName: $model->status?->name ?? 'N/A',
            categoryId: (int) $model->category_id,
            categoryName: $model->category?->name ?? 'N/A',
            userId: (int) $model->user_id,
            username: $model->user?->name ?? 'N/A'
        );
    }
}
