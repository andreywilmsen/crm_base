@extends('adminlte::page')

@section('title', isset($category) ? 'Editar Categoria' : 'Nova Categoria')

@section('content_header')
    <h1>{{ isset($category) ? 'Editar Categoria' : 'Nova Categoria' }}</h1>
@stop

@section('content')
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
            <h3 class="card-title">Dados da Categoria</h3>
        </div>

        <form
            action="{{ isset($category) ? route('record-category.update', $category->getId()) : route('record-category.store') }}"
            method="POST">
            @csrf
            @if (isset($category))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nome da Categoria</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', isset($category) ? $category->getName() : '') }}"
                                placeholder="Ex: Vendas, Aluguel, Despesas..." required autofocus>

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('record-category.index') }}" class="btn btn-default shadow-sm">Cancelar</a>
                <button type="submit" class="btn btn-primary shadow-sm ml-1">
                    <i class="fas fa-save"></i> {{ isset($category) ? 'Atualizar Categoria' : 'Salvar Categoria' }}
                </button>
            </div>
        </form>
    </div>
@stop
