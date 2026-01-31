<?php

namespace Modules\User\Application\UseCases;

use InvalidArgumentException;
use Modules\User\Domain\Entities\User;
use Modules\User\Domain\Repositories\UserRepositoryInterface;

class GetUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(int $id): User
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new InvalidArgumentException('Usuário não encontrado.');
        }

        return $user;
    }
}
