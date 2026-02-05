<?php

namespace Modules\Core\Application\User\UseCases;

use InvalidArgumentException;
use Modules\Core\Domain\User\Entities\User;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;

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
