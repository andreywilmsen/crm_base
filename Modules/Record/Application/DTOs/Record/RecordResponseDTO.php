<?php

namespace Modules\Record\Application\DTOs\Record;

readonly class RecordResponseDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $referenceDate,
        public readonly ?float $value,
        public readonly string $description,
        public readonly int $statusId,
        public readonly string $statusName,
        public readonly int $categoryId,
        public readonly string $categoryName,
        public readonly int $userId,
        public readonly string $username
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            title: $data['title'],
            referenceDate: $data['reference_date'],
            value: isset($data['value']) ? (float) $data['value'] : null,
            description: $data['description'] ?? '',
            statusId: (int) $data['status_id'],
            statusName: $data['status_name'] ?? 'N/A',
            categoryId: (int) $data['category_id'],
            categoryName: $data['category_name'] ?? 'N/A',
            userId: (int) $data['user_id'],
            username: $data['username'] ?? 'N/A'
        );
    }
}
