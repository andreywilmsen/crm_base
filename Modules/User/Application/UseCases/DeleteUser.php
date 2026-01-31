<?php

namespace Modules\User\Application\UseCases;

use InvalidArgumentException;
use Modules\User\Domain\Repositories\UserRepositoryInterface;

class DeleteUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(int $id): void
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new InvalidArgumentException('Usuário não encontrado.');
        }

        $this->userRepository->delete($user);
    }
}
