<?php
namespace Modules\Core\Domain\Table\Entities;

class TableColumn
{
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public array $options = [],
        public bool $searchable = true
    ) {}
}