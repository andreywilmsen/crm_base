<?php

namespace Modules\Collaborator\Application\DTOs;

use Illuminate\Http\Request;

class CollaboratorUpdateDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $phone,
        public readonly string $email,
    ) {}

    public static function fromRequest(Request $request, int $id): self
    {
        return new self(
            id: $id,
            name: $request->name,
            description: $request->description ?? '',
            phone: $request->phone ?? '',
            email: $request->email ?? '',
        );
    }
}
