<?php

namespace Modules\Record\Domain\Entities;

class RecordCategory
{
    public function __construct(
        private ?int $id,
        private string $name,
        private ?\DateTime $createdAt = null,
        private ?\DateTime $updatedAt = null
    ) {
        $this->validate();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function validate(): void
    {
        if (empty(trim($this->name))) {
            throw new \InvalidArgumentException('O nome da categoria é obrigatório.');
        }
    }
}
