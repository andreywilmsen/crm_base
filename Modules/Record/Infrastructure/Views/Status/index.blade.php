@extends('adminlte::page')

@section('title', 'Status de Registro')

@section('content_header')
    <h1>Status</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <a href="{{ route('record-status.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle"></i> Novo Status
            </a>
            <a href="{{ route('record.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left"></i> Voltar para Registros
            </a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="icon fas fa-ban"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon fas fa-check"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nome</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($status as $item)
                        <tr>
                            <td>{{ $item->getId() }}</td>
                            <td>{{ $item->getName() }}</td>
                            <td>
                                {{-- Link para Editar (Página separada) --}}
                                <a href="{{ route('record-status.show', $item->getId()) }}"
                                    class="btn btn-sm btn-info shadow-sm">
                                    Editar
                                </a>

                                <form action="{{ route('record-status.destroy', $item->getId()) }}" method="POST"
                                    style="display:inline" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-cat shadow-sm">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">Nenhum status encontrado.</td>
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
        $('.btn-delete-cat').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Deseja excluir este status?',
                text: "Isso pode afetar registros vinculados!",
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
