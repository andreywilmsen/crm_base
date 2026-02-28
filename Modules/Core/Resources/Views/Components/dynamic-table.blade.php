@props(['columns', 'records', 'editRoute', 'deleteRoute'])

<div class="table-responsive">
    {{-- FORM DE FILTRO --}}
    <form method="GET" action="{{ url()->current() }}" id="filter-form">
        <table class="table table-bordered table-striped table-hover mb-0 bg-white shadow-sm">
            <thead>
                <tr class="text-uppercase text-dark"
                    style="font-size: 0.75rem; background-color: #f8f9fa; letter-spacing: 0.5px;">
                    @foreach ($columns as $column)
                        <th class="align-middle border-bottom-0 py-3" style="width: {{ $column->width ?? 'auto' }}">
                            <strong>{{ $column->label }}</strong>
                        </th>
                    @endforeach
                    <th class="text-center align-middle border-bottom-0 py-3" style="width: 140px">Ações</th>
                </tr>

                <tr class="bg-white">
                    @foreach ($columns as $column)
                        <th class="p-2 border-top-0">
                            @if ($column->searchable)
                                @if ($column->type === 'select')
                                    <select name="{{ $column->name }}"
                                        class="form-control form-control-sm auto-submit border-gray shadow-none">
                                        <option value="">Todos</option>
                                        @foreach ($column->options as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ request($column->name) == (string) $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0 text-muted"><i
                                                    class="fas fa-search fa-xs"></i></span>
                                        </div>
                                        <input type="text" name="{{ $column->name }}"
                                            class="form-control form-control-sm border-left-0 shadow-none text-filter"
                                            placeholder="Filtrar..." value="{{ request($column->name) }}">
                                    </div>
                                @endif
                            @endif
                        </th>
                    @endforeach
                    <th class="text-center align-middle p-2 border-top-0">
                        <a href="{{ url()->current() }}"
                            class="btn btn-default btn-sm btn-block border shadow-sm text-muted bg-light"
                            title="Limpar">
                            <i class="fas fa-eraser"></i> Limpar
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse($records as $record)
                    @php $record = is_array($record) ? (object) $record : $record; @endphp
                    <tr>
                        @foreach ($columns as $column)
                            <td class="align-middle text-secondary" style="font-size: 0.9rem;">
                                @php $prop = $column->name; @endphp
                                @if ($column->type === 'money' || $prop === 'value')
                                    <span class="font-weight-bold text-dark">R$
                                        {{ number_format($record->$prop, 2, ',', '.') }}</span>
                                @elseif($column->type === 'date')
                                    {{ $record->$prop ? \Carbon\Carbon::parse($record->$prop)->format('d/m/Y') : '---' }}
                                @elseif($column->type === 'select' || $column->type === 'badge')
                                    <span
                                        class="badge badge-light border px-2 py-1 text-primary shadow-xs">{{ $record->$prop }}</span>
                                @else
                                    {{ $record->$prop }}
                                @endif
                            </td>
                        @endforeach

                        <td class="text-center align-middle">
                            <div class="btn-group shadow-sm border rounded" style="background: white;">
                                @if ($editRoute)
                                    <a href="{{ route($editRoute, $record->id) }}"
                                        class="btn btn-sm btn-white text-primary border-0" title="Editar"
                                        style="background: white; border-right: 1px solid #dee2e6 !important; border-radius: 4px 0 0 4px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                @if ($deleteRoute)
                                    {{-- AJUSTE: Botão agora usa data-url e não tem form interno --}}
                                    <button type="button"
                                        class="btn btn-sm btn-white text-danger border-0 btn-delete-confirm"
                                        data-url="{{ route($deleteRoute, $record->id) }}" title="Excluir"
                                        style="background: white; border-radius: 0 4px 4px 0;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x mb-3 text-light"></i><br>
                            <span class="text-muted small text-uppercase">Nenhum registro encontrado</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>

    @if ($records instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="px-3 py-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Mostrando <b>{{ $records->firstItem() }}</b> a <b>{{ $records->lastItem() }}</b> de
                <b>{{ $records->total() }}</b>
            </div>
            <div>{{ $records->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
        </div>
    @endif
</div>

{{-- AJUSTE: Form de delete único fora do form de filtro --}}
<form id="global-delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // Delegação de evento para os filtros
            $(document).on('change', '.auto-submit', function() {
                $('#filter-form').submit();
            });

            $(document).on('keypress', '.text-filter', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#filter-form').submit();
                }
            });

            // Lógica de Delete Global
            $(document).on('click', '.btn-delete-confirm', function(e) {
                e.preventDefault();
                const url = $(this).data('url');

                Swal.fire({
                    title: 'Deseja excluir?',
                    text: "Esta ação não poderá ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#global-delete-form').attr('action', url).submit();
                    }
                });
            });
        });
    </script>
@endpush
