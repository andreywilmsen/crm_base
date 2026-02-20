@extends('adminlte::page')

@section('title', 'Status de Registro')

@section('content_header')
    <h1>Status</h1>
@stop

@section('content')
    <div class="row">
        {{-- Formulário de Cadastro Rápido --}}
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Novo Status</h3>
                </div>
                <form action="{{ route('record-status.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nome do status</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex: Completo, Pendente..." required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabela de Listagem --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">ID</th>
                                <th>Nome</th>
                                <th style="width: 100px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($status as $item)
                                <tr>
                                    <td>{{ $item->getId() }}</td>
                                    <td>{{ $item->getName() }}</td>
                                    <td>
                                        <form action="{{ route('record-status.destroy', $item->getId()) }}" method="POST"
                                            class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-cat">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Nenhum status encontrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('record.index') }}" class="btn btn-default">Voltar para Registros</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.btn-delete-cat').on('click', function() {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Remover Status?',
                text: "Isso pode afetar registros vinculados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, remover!'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>
@stop
