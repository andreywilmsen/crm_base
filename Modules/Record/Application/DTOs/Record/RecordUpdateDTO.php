<?php

namespace Modules\Record\Application\DTOs\Record;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class RecordUpdateDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $referenceDate,
        public readonly ?float $value,
        public readonly string $description,
        public readonly int $statusId,
        public readonly int $categoryId,
        public readonly int $userId,
        public readonly ?UploadedFile $file = null 
    ) {}

    public static function fromRequest(Request $request, int $id): self
    {
        return new self(
            id: $id,
            title: $request->title,
            referenceDate: $request->reference_date,
            value: $request->value ? (float) $request->value : null,
            description: $request->description ?? '',
            statusId: (int) $request->status_id,
            categoryId: (int) $request->category_id,
            userId: (int) auth()->id(),
            file: $request->file('file') 
        );
    }
}