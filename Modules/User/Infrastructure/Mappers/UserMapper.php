<?php

namespace Modules\User\Infrastructure\Mappers;

use Modules\User\Domain\Entities\User as UserEntity;
use App\Models\User as UserModel;
use DateTime;

class UserMapper
{
    public static function toArray(UserEntity $user): array
    {
        $data = [
            'name'     => $user->getName(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
        ];

        if ($user->getId()) {
            $data['id'] = $user->getId();
        }

        if ($user->getEmailVerifiedAt()) {
            $data['email_verified_at'] = $user->getEmailVerifiedAt()->format('Y-m-d H:i:s');
        }

        return $data;
    }

    public static function toEntity(UserModel $data): UserEntity
    {
        return new UserEntity(
            id: $data->id,
            name: $data->name,
            email: $data->email,
            password: $data->password,
            rememberToken: $data->remember_token,
            emailVerifiedAt: $data->email_verified_at ? new DateTime($data->email_verified_at->format('Y-m-d H:i:s')) : null,
            createdAt: $data->created_at ? new DateTime($data->created_at->format('Y-m-d H:i:s')) : null,
            updatedAt: $data->updated_at ? new DateTime($data->updated_at->format('Y-m-d H:i:s')) : null
        );
    }

    public static function toResponse(UserEntity $user): array
    {
        return [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
            'verified_at' => $user->getEmailVerifiedAt()?->format('d/m/Y H:i'),
        ];
    }
}