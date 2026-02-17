<?php

namespace Modules\Record\Application\DTOs;

use Illuminate\Http\Request;

class RecordUpdateDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $referenceDate,
        public readonly ?float $value,
        public readonly string $description,
        public readonly string $status,
        public readonly int $userId
    ) {}

    public static function fromRequest(Request $request, int $id): self
    {
        return new self(
            id: $id,
            title: $request->title,
            referenceDate: $request->reference_date,
            value: $request->value ?? null,
            description: $request->description ?? '',
            status: $request->status,
            userId: (int) auth()->id(),
        );
    }
}
