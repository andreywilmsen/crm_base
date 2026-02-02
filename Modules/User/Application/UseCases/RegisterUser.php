<?php

namespace Modules\User\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\User\Application\DTOs\UserCreateDTO;
use Modules\User\Domain\Entities\User;
use Modules\User\Domain\Repositories\UserRepositoryInterface;

class RegisterUser
{

    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(UserCreateDTO $dto): User
    {
        $user = new User(
            id: null,
            name: $dto->name,
            email: $dto->email,
            emailVerifiedAt: null,
            password: Hash::make($dto->password),
            rememberToken: null,
            role: $dto->role
        );

        return $this->userRepository->save($user);
    }
}
