@extends('adminlte::page')

@section('title', 'Status de Registro')

@section('content_header')
    <h1>Status</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('record-status.create') }}" class="btn btn-primary shadow-sm px-3">
                    <i class="fas fa-plus-circle mr-1"></i> Novo Status
                </a>

                <a href="{{ route('record.index') }}" class="btn btn-default border shadow-sm text-dark">
                    <i class="fas fa-arrow-left text-secondary mr-1"></i> Voltar para Registros
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="bg-white">
                    <tr class="text-uppercase" style="font-size: 0.85rem; border-bottom: 2px solid #dee2e6;">
                        <th style="width: 80px; color: #495057;" class="align-middle border-top-0">#</th>
                        <th style="color: #495057;" class="align-middle border-top-0">Nome</th>
                        <th style="width: 150px; color: #495057;" class="text-center align-middle border-top-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($status as $item)
                        <tr>
                            <td class="align-middle">{{ $item->getId() }}</td>
                            <td class="align-middle">{{ $item->getName() }}</td>
                            <td class="text-center align-middle">
                                <div class="btn-group shadow-sm border rounded">
                                    <a href="{{ route('record-status.show', $item->getId()) }}"
                                        class="btn btn-sm btn-white text-primary border-0" title="Editar"
                                        style="background: white;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('record-status.destroy', $item->getId()) }}" method="POST"
                                        class="d-inline form-delete">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                            class="btn btn-sm btn-white text-danger border-0 btn-delete-cat" title="Excluir"
                                            style="background: white;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                Nenhum status encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('.btn-delete-cat').on('click', function(e) {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Deseja excluir?',
                    text: "Isso pode afetar registros vinculados!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@stop
