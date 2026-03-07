<?php

namespace Modules\Core\Application\User\DTOs;

use Illuminate\Http\Request;

readonly class UserCreateDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $role,
    ) {}

    public static function fromRequest(Request $request)
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
            role: $request->input('role')
        );
    }
}
