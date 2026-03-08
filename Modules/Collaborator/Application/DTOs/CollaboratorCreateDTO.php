<?php

namespace Modules\Collaborator\Application\DTOs;

use Illuminate\Http\Request;

readonly class CollaboratorCreateDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $phone,
        public readonly ?string $email,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            phone: $request->input('phone'),
            email: $request->input('email'),
        );
    }
}
