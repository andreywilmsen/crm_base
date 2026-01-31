<?php

namespace Modules\User\Infrastructure\Repositories;

use Modules\User\Domain\Entities\User;
use Modules\User\Infrastructure\Mappers\UserMapper;
use Modules\User\Domain\Repositories\UserRepositoryInterface;
use App\Models\User as UserModel;
use InvalidArgumentException;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function __construct(private readonly UserModel $userModel) {}

    public function save(User $user): User
    {
        $exists = $this->userModel->where('email', $user->getEmail())->where('id', '!=', $user->getId())->first();

        if ($exists) {
            throw new InvalidArgumentException('Este e-mail já está em uso por outro usuário.');
        }

        $data = UserMapper::toArray($user);

        $model = $this->userModel->updateOrCreate(
            ['id' => $user->getId()],
            $data
        );

        return UserMapper::toEntity($model);
    }

    public function delete(User $user): void
    {
        if (!$user->getId()) {
            throw new InvalidArgumentException('Usuário não cadastrado');
        }

        $this->userModel->destroy($user->getId());
    }

    public function findById(int $id): ?User
    {
        $user = $this->userModel->where('id', $id)->first();

        if (!$user) {
            return null;
        }

        return UserMapper::toEntity($user);
    }

    public function findByEmail(string $email): ?User
    {
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return null;
        }

        return UserMapper::toEntity($user);
    }

    public function findAll(): array
    {
        return $this->userModel->all()->map(fn($model) => UserMapper::toEntity($model))->all();
    }
}
