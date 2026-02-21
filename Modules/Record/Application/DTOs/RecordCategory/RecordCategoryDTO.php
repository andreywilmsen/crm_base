<?php

namespace Modules\Record\Application\DTOs\RecordCategory;

use Illuminate\Http\Request;

readonly class RecordCategoryDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?int $id = null,
    ) {}

    public static function fromRequest(Request $request, ?int $id = null): self
    {
        return new self(
            name: $request->input('name'),
            id: $id
        );
    }
}