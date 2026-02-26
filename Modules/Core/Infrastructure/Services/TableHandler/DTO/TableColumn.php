<?php

namespace Modules\Core\Infrastructure\Services\TableHandler\DTO;

class TableColumn
{
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public array $options = [],
        public ?string $filterClass = null
    ) {}
}
