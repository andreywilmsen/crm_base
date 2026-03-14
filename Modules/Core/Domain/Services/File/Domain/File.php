<?php

namespace Modules\Core\Domain\Services\File\Domain;

use InvalidArgumentException;

class File
{
    public function __construct(
        public readonly ?int $id,
        public string $name,
        public readonly string $path,
        public readonly string $mime,
        public readonly int  $size,
        public readonly string $disk,
        public readonly int $userId
    ) {
        $this->validate();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('O nome do arquivo é obrigatório.');
        }

        if (empty($this->path)) {
            throw new InvalidArgumentException('O caminho (path) do arquivo é obrigatório.');
        }

        if ($this->userId <= 0) {
            throw new InvalidArgumentException('O ID do usuário proprietário é inválido.');
        }

        if (!str_contains($this->mime, '/')) {
            throw new InvalidArgumentException("O formato MIME '{$this->mime}' é inválido.");
        }

        if (is_numeric($this->size) && (int)$this->size <= 0) {
            throw new InvalidArgumentException('O tamanho do arquivo deve ser maior que zero.');
        }
    }

    public function toArray(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'path'    => $this->path,
            'mime'    => $this->mime,
            'size'    => $this->size,
            'disk'    => $this->disk,
            'user_id' => $this->userId,
        ];
    }
}
