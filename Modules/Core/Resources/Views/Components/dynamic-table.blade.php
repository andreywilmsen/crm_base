@props(['columns', 'records', 'editRoute', 'deleteRoute'])

<div class="table-responsive">
    <form method="GET" action="{{ url()->current() }}" id="filter-form">
        <table class="table table-bordered table-striped table-hover mb-0 bg-white">
            <thead>
                {{-- Linha 1: Títulos das Colunas --}}
                <tr class="text-uppercase text-muted" style="font-size: 0.85rem; background-color: #f4f6f9;">
                    @foreach ($columns as $column)
                        <th class="align-middle" style="width: {{ $column->width ?? 'auto' }}">
                            {{ $column->label }}
                        </th>
                    @endforeach
                    <th class="text-center align-middle" style="width: 160px">Ações</th>
                </tr>

                {{-- Linha 2: Filtros Integrados --}}
                <tr class="bg-light">
                    @foreach ($columns as $column)
                        <th class="p-2">
                            @if ($column->searchable)
                                @if ($column->type === 'select')
                                    <select name="{{ $column->name }}" class="form-control form-control-sm auto-submit shadow-sm">
                                        <option value="">Todos</option>
                                        @foreach ($column->options as $key => $value)
                                            <option value="{{ $key }}" {{ request($column->name) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif($column->type === 'date')
                                    <input type="date" name="{{ $column->name }}"
                                        class="form-control form-control-sm auto-submit shadow-sm" 
                                        value="{{ request($column->name) }}">
                                @else
                                    <input type="text" name="{{ $column->name }}" 
                                        class="form-control form-control-sm shadow-sm text-filter"
                                        placeholder="🔍 Buscar..."
                                        value="{{ request($column->name) }}">
                                @endif
                            @endif
                        </th>
                    @endforeach
                    <th class="text-center align-middle p-2">
                        <a href="{{ url()->current() }}" class="btn btn-default btn-sm btn-block border shadow-sm bg-white" title="Limpar">
                            <i class="fas fa-sync-alt text-muted"></i> Reset
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        @foreach ($columns as $column)
                            <td class="align-middle">
                                @php $prop = $column->name; @endphp

                                @if ($column->type === 'money' || $prop === 'value')
                                    <span class="text-bold text-dark">R$ {{ number_format($record->$prop, 2, ',', '.') }}</span>
                                @elseif($column->type === 'date' || str_contains($prop, 'Date'))
                                    <span class="text-muted">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $record->$prop ? \Carbon\Carbon::parse($record->$prop)->format('d/m/Y') : '---' }}
                                    </span>
                                @elseif($column->type === 'select')
                                    <span class="badge badge-info px-2 py-1">{{ $record->$prop }}</span>
                                @else
                                    {{ $record->$prop }}
                                @endif
                            </td>
                        @endforeach

                        <td class="text-center align-middle">
                            <div class="btn-group">
                                @if ($editRoute)
                                    <a href="{{ route($editRoute, $record->id) }}"
                                        class="btn btn-sm btn-primary shadow-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                @if ($deleteRoute)
                                    <form action="{{ route($deleteRoute, $record->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger shadow-sm btn-delete-confirm" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 text-light"></i><br>
                                Nenhum dado encontrado para esta consulta.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>

    {{-- Paginação Padrão AdminLTE --}}
    @if($records instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="px-3 py-3 border-top bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Exibindo <b>{{ $records->firstItem() }}</b> - <b>{{ $records->lastItem() }}</b> de <b>{{ $records->total() }}</b>
            </div>
            <div>
                {{ $records->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @endif
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // Auto-submit para Select e Date
            $('.auto-submit').on('change', function() {
                $('#filter-form').submit();
            });

            // Enter no input de texto
            $('.text-filter').on('keypress', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#filter-form').submit();
                }
            });

            // SweetAlert Delete
            $('.btn-delete-confirm').on('click', function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Deseja excluir?',
                    text: "Essa operação não pode ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endpush