<?php

namespace Modules\User\Domain\Entities;

use DateTime;
use InvalidArgumentException;

class User
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private ?DateTime $emailVerifiedAt,
        private string $password,
        private ?string $rememberToken,
        private ?DateTime $createdAt = null,
        private ?DateTime $updatedAt = null,
        private ?string $role = null
    ) {
        $this->validate();
        $this->role = $role;
    }


    // Getters

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?DateTime
    {
        return $this->emailVerifiedAt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    // Validador

    public function validate()
    {
        $this->name = preg_replace('/\s+/', ' ', trim($this->name));

        if (empty($this->name)) {
            throw new InvalidArgumentException('O nome é obrigatório.');
        }

        if (strlen($this->name) < 3) {
            throw new InvalidArgumentException('O nome deverá ter mais que 3 caracteres.');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('E-mail inválido.');
        }

        if (empty($this->password)) {
            throw new InvalidArgumentException('A senha é obrigatória.');
        }
    }

    // Utilitarios

    public function resetPassword(string $hashedPassword): string
    {
        return $this->password = $hashedPassword;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'createdAt' => $this->createdAt,
        ];
    }
}
