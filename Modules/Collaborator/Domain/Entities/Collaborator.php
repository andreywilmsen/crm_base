<?php

namespace Modules\Collaborator\Domain\Entities;

use InvalidArgumentException;

class Collaborator
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $description = null,
        private readonly ?string $phone = null,
        private readonly ?string $email = null,
        private ?int $id = null,
    ) {
        $this->validate();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDescription()
    {
        return $this->description;
    }


    // Validadores

    private function validate()
    {
        if (empty(trim($this->name))) {
            throw new InvalidArgumentException('Campo nome é obrigatório.');
        }
    }

    // Utilitários

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email
        ];
    }
}
