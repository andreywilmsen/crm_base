<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Domain\Repositories\UserRepositoryInterface;

class GetAllUsers
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute(): array
    {
        return $this->userRepository->findAll();
    }
}
