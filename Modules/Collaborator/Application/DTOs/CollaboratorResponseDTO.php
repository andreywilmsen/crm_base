<?php

namespace Modules\Collaborator\Application\DTOs;

readonly class CollaboratorResponseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $phone,
        public string $email,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: $data['name'] ?? '',
            description: $data['description'] ?? '',
            phone: $data['phone'] ?? '',
            email: $data['email'] ?? '',
        );
    }
}
