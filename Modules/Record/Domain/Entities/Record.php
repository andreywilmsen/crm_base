<?php

namespace Modules\Record\Domain\Entities;

use InvalidArgumentException;

class Record
{
    public function __construct(
        private readonly string $title,
        private readonly string $referenceDate,
        private readonly ?float $value = null,
        private readonly string $description,
        private readonly int $statusId,
        private readonly int $userId,
        private readonly int $categoryId,
        private ?int $id = null,
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

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
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

        if ($this->value !== null && $this->value < 0) {
            throw new InvalidArgumentException('Valores negativos não são permitidos.');
        }

        if ($this->statusId === null || $this->statusId <= 0) {
            throw new InvalidArgumentException('Campo status é obrigatório.');
        }

        if (empty($this->categoryId)) {
            throw new InvalidArgumentException('Campo categoria é obrigatório.');
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
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $this->userId,
        ];
    }
}
