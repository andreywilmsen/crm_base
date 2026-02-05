<?php

namespace Modules\Core\Application\User\UseCases;

use InvalidArgumentException;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;

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
