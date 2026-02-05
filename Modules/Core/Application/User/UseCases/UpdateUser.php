<?php

namespace Modules\Core\Application\User\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Core\Application\User\DTOs\UserUpdateDTO;
use Modules\Core\Domain\User\Entities\User;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;

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
            rememberToken: $user->getRememberToken(),
            role: $dto->role
        );

        return $this->userRepository->save($updatedUser);
    }
}
