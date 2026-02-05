<?php

namespace Modules\Core\Infrastructure\User\Repositories;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Modules\Core\Domain\User\Entities\User;
use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;
use Modules\Core\Infrastructure\User\Mappers\UserMapper;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function __construct(private readonly UserModel $userModel) {}

    public function save(User $user): User
    {
        $exists = $this->userModel->where('email', $user->getEmail())->where('id', '!=', $user->getId())->first();

        if ($exists) {
            throw new InvalidArgumentException('Este e-mail já está em uso por outro usuário.');
        }

        return DB::transaction(function () use ($user) {
            $data = UserMapper::toArray($user);

            $model = $this->userModel->updateOrCreate(
                ['id' => $user->getId()],
                $data
            );

            if ($user->getRole()) {
                $model->syncRoles($user->getRole());
            }

            return UserMapper::toEntity($model);
        });
    }

    public function delete(User $user): void
    {
        if (!$user->getId()) {
            throw new InvalidArgumentException('Usuário não cadastrado');
        }

        $this->userModel->destroy($user->getId());
    }

    public function resetPassword(User $user, string $hashedPassword): void
    {
        $user->resetPassword($hashedPassword);

        $this->save($user);
    }

    public function findById(int $id): ?User
    {
        $user = $this->userModel->with('roles')->where('id', $id)->first();

        if (!$user) {
            return null;
        }

        return UserMapper::toEntity($user);
    }

    public function findByEmail(string $email): ?User
    {
        $user = $this->userModel->with('roles')->where('email', $email)->first();

        if (!$user) {
            return null;
        }

        return UserMapper::toEntity($user);
    }

    public function findAll(): array
    {
        return $this->userModel->with('roles')->get()
            ->map(fn($model) => UserMapper::toEntity($model))
            ->all();
    }
}
