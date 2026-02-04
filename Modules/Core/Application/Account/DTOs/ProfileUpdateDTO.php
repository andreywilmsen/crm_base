<?php

namespace Modules\Core\Application\Account\DTOs;

use Illuminate\Http\Request;

readonly class ProfileUpdateDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password = null
    ) {}

    public static function fromRequest(array $validatedData, int $userId): self
    {
        return new self(
            id: $userId,
            name: $validatedData['name'],
            email: $validatedData['email'],
            password: $validatedData['password'] ?? null
        );
    }
}
