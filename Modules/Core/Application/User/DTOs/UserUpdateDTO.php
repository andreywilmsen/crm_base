<?php

namespace Modules\Core\Application\User\DTOs;

use Illuminate\Http\Request;

readonly class UserUpdateDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $role
    ) {}

    public static function fromRequest(Request $request, int $id)
    {
        return new self(
            id: $id ?? $request->route('user') ?? $request->input('id'),
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
            role: $request->input('role')
        );
    }
}
