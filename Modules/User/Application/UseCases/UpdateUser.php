<?php

namespace Modules\User\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\User\Application\DTOs\UserUpdateDTO;
use Modules\User\Domain\Entities\User;
use Modules\User\Domain\Repositories\UserRepositoryInterface;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(UserUpdateDTO $dto): User
    {
        $user = $this->userRepository->findById($dto->id);

        $updatedUser = new User(
            id: $user->getId(),
            name: $dto->name,
            email: $dto->email,
            emailVerifiedAt: $user->getEmailVerifiedAt(),
            password: $dto->password ? Hash::make($dto->password) : $user->getPassword(),
            rememberToken: $user->getRememberToken()
        );

        return $this->userRepository->save($updatedUser);
    }
}
