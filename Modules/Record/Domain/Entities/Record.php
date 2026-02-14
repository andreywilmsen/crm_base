<?php

namespace Modules\Record\Domain\Entities;

use InvalidArgumentException;

class Record
{
    public function __construct(
        private readonly string $title,
        private readonly string $referenceDate,
        private readonly float $value,
        private readonly string $description,
        private readonly string $status,
        private readonly int $userId,
        private ?int $id = null
    ) {
        $this->validate();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getReferenceDate()
    {
        return $this->referenceDate;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUserId()
    {
        return $this->userId;
    }


    // Validadores

    private function validate()
    {
        if (empty(trim($this->title))) {
            throw new InvalidArgumentException('Campo título é obrigatório.');
        }

        if (empty($this->referenceDate)) {
            throw new InvalidArgumentException('Campo data é obrigatório.');
        }

        if (empty(trim($this->description))) {
            throw new InvalidArgumentException('Campo descrição é obrigatório.');
        }

        if ($this->value < 0) {
            throw new InvalidArgumentException('Valores negativos não são permitidos.');
        }

        if (empty($this->status)) {
            throw new InvalidArgumentException('Campo status é obrigatório.');
        }

        if (empty($this->userId)) {
            throw new InvalidArgumentException('Campo responsável é obrigatório.');
        }
    }

    // Utilitários

    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'reference_date' => $this->referenceDate,
            'value'          => $this->value,
            'description'    => $this->description,
            'status'         => $this->status,
            'user_id'        => $this->userId,
        ];
    }
}
