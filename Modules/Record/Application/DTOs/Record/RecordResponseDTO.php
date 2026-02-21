<?php

namespace Modules\Record\Application\DTOs\Record;

readonly class RecordResponseDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $referenceDate,
        public ?float $value,
        public string $description,
        public int $statusId,
        public string $statusName,
        public int $categoryId,
        public string $categoryName,
        public int $userId,
        public string $username
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
