<?php

namespace Modules\Core\Presentation\Components;

use Illuminate\View\Component;

class DynamicTable extends Component
{
    public function __construct(
        public array $columns,
        public $records,
        public ?string $editRoute = null,
        public ?string $deleteRoute = null
    ) {}

    public function render()
    {
        return view('core::components.table.dynamic-table');
    }
}
