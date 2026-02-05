<?php

namespace Modules\Core\Application\User\UseCases;

use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;

class GetAllUsers
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(): array
    {
        return $this->userRepository->findAll();
    }
}
