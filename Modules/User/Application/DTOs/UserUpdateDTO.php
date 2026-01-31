<?php

namespace Modules\User\Application\DTOs;

use Illuminate\Http\Request;

readonly class UserUpdateDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password = null
    ) {}

    public static function fromRequest(Request $request, int $id)
    {
        return new self(
            id: $id ?? $request->route('user') ?? $request->input('id'),
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
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
