<?php

namespace Modules\Collaborator\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Collaborator\Application\DTOs\CollaboratorResponseDTO;
use Modules\Collaborator\Domain\Entities\Collaborator;
use Modules\Collaborator\Domain\Repositories\CollaboratorRepositoryInterface;
use Modules\Collaborator\Infrastructure\Mappers\CollaboratorMapper;
use Modules\Collaborator\Infrastructure\Persistence\Eloquent\CollaboratorModel;

class EloquentCollaboratorRepository implements CollaboratorRepositoryInterface
{
    public function __construct(private readonly CollaboratorModel $collaboratorModel) {}

    public function save(Collaborator $collaborator): Collaborator
    {
        return DB::transaction(function () use ($collaborator) {
            $data = CollaboratorMapper::toPersistence($collaborator);

            $model = $this->collaboratorModel->updateOrCreate(
                ['id' => $collaborator->getId()],
                $data
            );

            $model->refresh();

            return CollaboratorMapper::toEntity($model);
        });
    }

    public function delete(Collaborator $collaborator): void
    {
        $this->collaboratorModel->destroy($collaborator->getId());
    }

    public function findById(int $id): ?Collaborator
    {
        $collaborator = $this->collaboratorModel->find($id);

        if (!$collaborator) {
            return null;
        }

        return CollaboratorMapper::toEntity($collaborator);
    }

    public function findByIdForResponse(int $id): ?CollaboratorResponseDTO
    {
        $collaborator = $this->collaboratorModel->find($id);

        if (!$collaborator) {
            return null;
        }
        return CollaboratorMapper::toResponseDTO($collaborator);
    }

    public function findByName(string $name): ?Collaborator
    {
        $collaborator = $this->collaboratorModel->where('name', $name)->first();

        if (!$collaborator) {
            return null;
        }

        return CollaboratorMapper::toEntity($collaborator);
    }

    public function findAll(): array
    {
        return $this->collaboratorModel->all()
            ->map(fn($m) => CollaboratorMapper::toEntity($m))
            ->all();
    }

    public function getQueryBuilder(): Builder
    {
        return $this->collaboratorModel->query();
    }
}
