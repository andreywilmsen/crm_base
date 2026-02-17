<?php

namespace Modules\Record\Application\DTOs;

use Illuminate\Http\Request;

readonly class RecordCreateDTO
{
    public function __construct(
        public string $title,
        public string $referenceDate,
        public ?float $value,
        public string $description,
        public string $status,
        public int $userId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->input('title'),
            referenceDate: $request->input('reference_date'),
            value: $request->input('value') ?? null,
            description: $request->input('description'),
            status: $request->input('status'),
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
            'status'         => $this->status,
            'user_id'        => $this->userId,
        ];
    }
}
