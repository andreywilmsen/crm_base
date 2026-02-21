<?php

namespace Modules\Record\Application\DTOs\RecordStatus;

use Illuminate\Http\Request;

readonly class RecordStatusDTO
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
