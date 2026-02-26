@props(['columns', 'records', 'routes'])

<form action="{{ $routes['index'] }}" method="GET" id="filter-form">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                @foreach ($columns as $col)
                    <th style="{{ $col->name == 'id' ? 'width: 80px' : '' }}">{{ $col->label }}</th>
                @endforeach
                <th style="width: 150px">Ações</th>
            </tr>
            <tr class="bg-light">
                @foreach ($columns as $col)
                    <th>
                        @if ($col->type === 'select')
                            <select name="{{ $col->name }}" class="form-control form-control-sm auto-submit">
                                <option value="">Todos</option>
                                @foreach ($col->options as $val => $lab)
                                    <option value="{{ $val }}"
                                        {{ request($col->name) == $val ? 'selected' : '' }}>
                                        {{ $lab }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($col->type === 'date')
                            <input type="date" name="{{ $col->name }}"
                                class="form-control form-control-sm auto-submit" value="{{ request($col->name) }}">
                        @else
                            <input type="text" name="{{ $col->name }}" class="form-control form-control-sm"
                                value="{{ request($col->name) }}" placeholder="{{ $col->label }}...">
                        @endif
                    </th>
                @endforeach
                <th class="text-center">
                    <a href="{{ $routes['index'] }}" class="btn btn-default btn-sm btn-block border">
                        <i class="fas fa-times"></i> Limpar
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    @foreach ($columns as $col)
                        <td>
                            @php $value = data_get($record, $col->name); @endphp

                            @if ($col->name === 'value')
                                R$ {{ number_format($value, 2, ',', '.') }}
                            @elseif($col->type === 'date' || str_contains($col->name, 'Date'))
                                {{ $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : '---' }}
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    @endforeach
                    <td>
                        <a href="{{ route($routes['edit'], $record->id) }}"
                            class="btn btn-sm btn-info shadow-sm">Editar</a>
                        <form action="{{ route($routes['delete'], $record->id) }}" method="POST"
                            style="display:inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete shadow-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" class="text-center py-4 text-muted">Nenhum registro
                        encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</form>

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Auto-submit para Selects e Datas
        $('.auto-submit').on('change', function() {
            $('#filter-form').submit();
        });

        // Submit no Enter para inputs de texto
        $('#filter-form input[type="text"]').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#filter-form').submit();
            }
        });

        // SweetAlert para delete
        $(document).on('click', '.btn-delete', function(e) {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Excluir registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>
@stop
