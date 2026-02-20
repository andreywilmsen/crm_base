<?php

namespace Modules\Record\Application\DTOs\Record;

use Illuminate\Http\Request;

readonly class RecordCreateDTO
{
    public function __construct(
        public string $title,
        public string $referenceDate,
        public ?float $value,
        public string $description,
        public int $statusId,
        public int $categoryId,
        public int $userId,
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
