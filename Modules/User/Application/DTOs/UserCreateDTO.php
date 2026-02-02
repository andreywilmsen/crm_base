<?php

namespace Modules\User\Application\DTOs;

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

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
