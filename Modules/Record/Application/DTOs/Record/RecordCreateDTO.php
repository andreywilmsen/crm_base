<?php

namespace Modules\Record\Application\DTOs\Record;

use Illuminate\Http\Request;

readonly class RecordCreateDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $referenceDate,
        public readonly ?float $value,
        public readonly string $description,
        public readonly int $statusId,
        public readonly int $categoryId,
        public readonly int $userId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->input('title'),
            referenceDate: $request->input('reference_date'),
            value: $request->input('value') ?? null,
            description: $request->input('description'),
            statusId: (int) $request->input('status_id'),
            categoryId: $request->input('category_id'),
            userId: (int) $request->user()?->id ?? $request->input('user_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'title'          => $this->title,
            'reference_date' => $this->referenceDate,
            'value'          => $this->value,
            'description'    => $this->description,
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $this->userId,
        ];
    }
}
