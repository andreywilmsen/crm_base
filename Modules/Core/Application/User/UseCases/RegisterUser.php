<?php

namespace Modules\Core\Application\User\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Core\Application\User\DTOs\UserCreateDTO;
use Modules\Core\Domain\User\Entities\User;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;

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
