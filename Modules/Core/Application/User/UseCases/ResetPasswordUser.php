<?php

namespace Modules\Core\Application\User\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;

class ResetPasswordUser
{
    public function __construct(public readonly UserRepositoryInterface $userRepository) {}

    public function execute(int $id)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new \InvalidArgumentException("Usuário não encontrado.");
        }

        $passwordHashed = Hash::make(config('user_module.default_password'));

        $this->userRepository->resetPassword($user, $passwordHashed);
    }
}
