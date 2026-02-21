@extends('adminlte::page')

@section('title', isset($status) ? 'Editar Status' : 'Novo Status')

@section('content_header')
    <h1>{{ isset($status) ? 'Editar Status' : 'Novo Status' }}</h1>
@stop

@section('content')
    {{-- Bloco de Erros --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible shadow-sm">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Erro!</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Dados do Status</h3>
        </div>

        <form
            action="{{ isset($status) ? route('record-status.update', $status->getId()) : route('record-status.store') }}"
            method="POST">
            @csrf
            @if (isset($status))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nome do Status</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', isset($status) ? $status->getName() : '') }}"
                                placeholder="Ex: Completo, Pendente, Em Análise..." required autofocus>

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('record-status.index') }}" class="btn btn-default shadow-sm">Cancelar</a>
                <button type="submit" class="btn btn-primary shadow-sm ml-1">
                    <i class="fas fa-save"></i> {{ isset($status) ? 'Atualizar Status' : 'Salvar Status' }}
                </button>
            </div>
        </form>
    </div>
@stop