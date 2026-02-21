<?php

namespace Modules\Record\Application\UseCases\RecordCategory;

use InvalidArgumentException;
use Modules\Record\Application\DTOs\RecordCategory\RecordCategoryDTO;
use Modules\Record\Domain\Entities\RecordCategory;
use Modules\Record\Domain\Repositories\RecordCategoryRepositoryInterface;

class UpdateRecordCategory
{
    public function __construct(private RecordCategoryRepositoryInterface $repository) {}

    public function execute(RecordCategoryDTO $dto): RecordCategory
    {
        $existingCategory = $this->repository->findById($dto->id);

        if (!$existingCategory) {
            throw new InvalidArgumentException("Categoria com ID {$dto->id} não encontrado.");
        }

        $category = new RecordCategory(
            id: $dto->id,
            name: $dto->name
        );

        return $this->repository->save($category);
    }
}
