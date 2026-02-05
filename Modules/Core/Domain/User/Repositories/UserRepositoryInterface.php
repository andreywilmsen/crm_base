<?php

namespace Modules\Core\Domain\User\Repositories;

use Modules\Core\Domain\User\Entities\User;

interface UserRepositoryInterface {
    
    public function save(User $user): User;

    public function delete(User $user): void;

    public function resetPassword(User $user, string $hashedPassword): void;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findAll(): array;

}