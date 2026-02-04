<?php

namespace Modules\Core\Application\Account\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Core\Application\Account\DTOs\ProfileUpdateDTO;
use Modules\User\Domain\Entities\User;
use Modules\User\Domain\Repositories\UserRepositoryInterface;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(ProfileUpdateDTO $dto): User
    {
        $user = $this->userRepository->findById($dto->id);

        if (!$user) {
            throw new \InvalidArgumentException('Usuário não encontrado.');
        }

        $updatedUser = new User(
            id: $user->getId(),
            name: $dto->name,
            email: $dto->email,
            emailVerifiedAt: $user->getEmailVerifiedAt(),
            password: $dto->password ? Hash::make($dto->password) : $user->getPassword(),
            rememberToken: $user->getRememberToken(),
            role: $user->getRole()
        );

        return $this->userRepository->save($updatedUser);
    }
}
