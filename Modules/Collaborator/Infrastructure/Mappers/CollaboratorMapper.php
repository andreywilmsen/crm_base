<?php

namespace Modules\Collaborator\Infrastructure\Mappers;

use Modules\Collaborator\Application\DTOs\CollaboratorResponseDTO;
use Modules\Collaborator\Domain\Entities\Collaborator as CollaboratorEntity;
use Modules\Collaborator\Infrastructure\Persistence\Eloquent\CollaboratorModel;

class CollaboratorMapper
{
    /**
     * Mapeia a Entidade para o formato de banco de dados (Eloquent).
     */
    public static function toPersistence(CollaboratorEntity $collaborator): array
    {
        return [
            'id'          => $collaborator->getId(),
            'name'        => $collaborator->getName(),
            'description' => $collaborator->getDescription(),
            'phone'       => $collaborator->getPhone(),
            'email'       => $collaborator->getEmail(),
        ];
    }

    /**
     * Converte o Model Eloquent em Entidade de Domínio.
     */
    public static function toEntity(CollaboratorModel $model): CollaboratorEntity
    {
        return new CollaboratorEntity(
            name: $model->name,
            description: $model->description,
            phone: $model->phone,
            email: $model->email,
            id: (int) $model->id
        );
    }

    /**
     * Converte o Model Eloquent em DTO de Resposta para a UI.
     */
    public static function toResponseDTO(CollaboratorModel $model): CollaboratorResponseDTO
    {
        return new CollaboratorResponseDTO(
            id: (int) $model->id,
            name: $model->name,
            description: $model->description ?? '',
            phone: $model->phone ?? '',
            email: $model->email ?? '',
        );
    }

    /**
     * Transforma um DTO de Entrada (Create/Update) em Entidade de Domínio.
     */
    public static function fromDTO(object $dto): CollaboratorEntity
    {
        return new CollaboratorEntity(
            name: $dto->name,
            description: $dto->description ?? null,
            phone: $dto->phone ?? null,
            email: $dto->email ?? null,
            id: property_exists($dto, 'id') ? (int) $dto->id : null
        );
    }
}
