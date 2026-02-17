@extends('adminlte::page')

@section('title', 'Registros Financeiros')

@section('content_header')
    <h1>Lista de Registros</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('record.create') }}" class="btn btn-primary">Novo Registro</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon fas fa-check"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Título</th>
                        <th>Data Ref.</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $record['id'] }}</td>
                            <td>{{ $record['title'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($record['reference_date'])->format('d/m/Y') }}</td>
                            <td>{{ $record['value'] ? 'R$ ' . number_format($record['value'], 2, ',', '.') : '---' }}</td>                            <td>
                                <span
                                    class="badge badge-{{ $record['status'] == 'completed' ? 'success' : ($record['status'] == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($record['status']) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('record.show', $record['id']) }}" class="btn btn-sm btn-info">Editar</a>
                                <form action="{{ route('record.destroy', $record['id']) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Deseja excluir este registro?',
                text: "Esta ação não pode ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    </script>
@stop
