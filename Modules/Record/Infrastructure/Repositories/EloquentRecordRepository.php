<?php

namespace Modules\Record\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Record\Application\DTOs\Record\RecordResponseDTO;
use Modules\Record\Domain\Entities\Record;
use Modules\Record\Domain\Repositories\RecordRepositoryInterface;
use Modules\Record\Infrastructure\Mappers\RecordMapper;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;

class EloquentRecordRepository implements RecordRepositoryInterface
{
    public function __construct(private readonly RecordModel $recordModel) {}

    public function save(Record $record): Record
    {
        return DB::transaction(function () use ($record) {
            $data = RecordMapper::toArray($record);

            $model = $this->recordModel->updateOrCreate(
                ['id' => $record->getId()],
                $data
            );

            return RecordMapper::toEntity($model->load(['user', 'category', 'status']));
        });
    }

    public function delete(Record $record): void
    {
        $this->recordModel->destroy($record->getId());
    }

    public function findById(int $id): ?Record
    {
        $record = $this->recordModel->with(['user', 'category', 'status'])->find($id);

        if (!$record) {
            return null;
        }

        return RecordMapper::toEntity($record);
    }

    public function findByIdForResponse(int $id): ?RecordResponseDTO
    {
        $record = $this->recordModel->with(['user', 'category', 'status'])->find($id);

        if (!$record) {
            return null;
        }
        return RecordMapper::toResponseDTO($record);
    }

    public function findByTitle(string $title): ?Record
    {
        $record = $this->recordModel->where('title', $title)->first();

        if (!$record) {
            return null;
        }

        return RecordMapper::toEntity($record);
    }

    public function findAll(): array
    {
        return $this->recordModel->with(['user', 'category', 'status'])->get()
            ->map(fn($model) => RecordMapper::toResponseDTO($model))
            ->all();
    }
}
