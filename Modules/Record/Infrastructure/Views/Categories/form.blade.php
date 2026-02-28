@extends('adminlte::page')

@section('title', isset($category) ? 'Editar Categoria' : 'Nova Categoria')

@section('content_header')
    <div class="d-flex align-items-center">
        <a href="{{ route('record-category.index') }}" class="btn btn-default btn-sm border shadow-sm mr-3">
            <i class="fas fa-arrow-left text-muted"></i>
        </a>
        <h1 class="m-0 text-dark">{{ isset($category) ? 'Editar Categoria' : 'Nova Categoria' }}</h1>
    </div>
@stop

@section('content')
    <div class="mt-3">
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 fade show" role="alert">
                <div class="d-flex">
                    <i class="fas fa-exclamation-circle fa-lg mr-3 mt-1"></i>
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li><strong>Erro:</strong> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="card-title text-muted">
                    <i class="fas fa-tag mr-2"></i>
                    <span class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px; font-weight: 700;">
                        Informações da Categoria
                    </span>
                </h3>
                <div class="card-tools">
                    <span class="badge badge-light border text-secondary px-2 py-1">
                        ID: {{ isset($category) ? $category->getId() : 'Novo' }}
                    </span>
                </div>
            </div>

            <form
                action="{{ isset($category) ? route('record-category.update', $category->getId()) : route('record-category.store') }}"
                method="POST">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif

                <div class="card-body py-4 bg-light-50">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label for="name" class="text-uppercase font-weight-bold">Nome da Categoria</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name', isset($category) ? $category->getName() : '') }}"
                                        placeholder="Ex: Vendas, Aluguel, Despesas..." required autofocus>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block small mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-right py-3">
                    <a href="{{ route('record-category.index') }}"
                        class="btn btn-default border shadow-sm px-3 mr-1 text-dark">
                        <i class="fas fa-times mr-1 text-muted"></i> Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary shadow-sm px-3">
                        <i class="fas fa-check mr-1"></i>
                        {{ isset($category) ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@stop
