@extends('adminlte::page')

@section('title', isset($collaborator) ? 'Editar Colaborador' : 'Novo Colaborador')

@section('content_header')
    <div class="d-flex align-items-center">
        <a href="{{ route('collaborator.index') }}" class="btn btn-default btn-sm border shadow-sm mr-3">
            <i class="fas fa-arrow-left text-muted"></i>
        </a>
        <h1 class="m-0 text-dark">{{ isset($collaborator) ? 'Editar Colaborador' : 'Novo Colaborador' }}</h1>
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
                    <i class="fas fa-edit mr-2"></i>
                    <span class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px; font-weight: 700;">
                        Informações Gerais
                    </span>
                </h3>
                @if (isset($collaborator))
                    <div class="card-tools">
                        <span class="badge badge-light border text-secondary px-2 py-1">ID #{{ $collaborator->id }}</span>
                    </div>
                @endif
            </div>

            <form
                action="{{ isset($collaborator) ? route('collaborator.update', $collaborator->id) : route('collaborator.store') }}"
                method="POST">
                @csrf
                @if (isset($collaborator))
                    @method('PUT')
                @endif

                <div class="card-body bg-light-50">
                    <div class="row">
                        {{-- Nome --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="small text-uppercase text-muted font-weight-bold">Nome</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-heading text-light"></i></span>
                                    </div>
                                    <input type="text" name="name"
                                        class="form-control border-left-0 shadow-none @error('name') is-invalid @enderror"
                                        id="name" value="{{ old('name', $collaborator->name ?? '') }}"
                                        placeholder="Ex: José da Silva" required>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email" class="small text-uppercase text-muted font-weight-bold">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-heading text-light"></i></span>
                                    </div>
                                    <input type="email" name="email"
                                        class="form-control border-left-0 shadow-none @error('email') is-invalid @enderror"
                                        id="email" value="{{ old('email', $collaborator->email ?? '') }}"
                                        placeholder="Ex: jose@empresa.com">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Telefone --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone"
                                    class="small text-uppercase text-muted font-weight-bold">Telefone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-heading text-light"></i></span>
                                    </div>
                                    <input type="text" name="phone"
                                        class="form-control border-left-0 shadow-none @error('phone') is-invalid @enderror"
                                        id="phone" value="{{ old('phone', $collaborator->phone ?? '') }}"
                                        placeholder="Ex: (51) 99999-9999">
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback d-block small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="form-group mt-2">
                        <label for="description" class="small text-uppercase text-muted font-weight-bold">Descrição</label>
                        <textarea name="description" class="form-control shadow-none @error('description') is-invalid @enderror"
                            id="description" rows="3" placeholder="Descrição do colaborador">{{ old('description', $collaborator->description ?? '') }}</textarea>
                    </div>

                    {{-- @if (isset($collaborator))
                        <div class="mt-4 p-3 bg-white border rounded d-flex align-items-center justify-content-between">
                            <span class="small text-muted italic">
                                <i class="fas fa-history mr-1"></i> Histórico do registro
                            </span>
                            <span class="small font-weight-bold text-secondary">
                                <i class="fas fa-user-edit mr-1 text-light"></i> Editado por: {{ $collaborator->username }}
                            </span>
                        </div>
                    @else
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endif --}}
                </div>

                <div class="card-footer bg-white border-top text-right py-3">
                    <a href="{{ route('collaborator.index') }}"
                        class="btn btn-default border shadow-sm px-3 mr-1 text-dark">
                        <i class="fas fa-times mr-1 text-muted"></i> Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary shadow-sm px-3">
                        <i class="fas fa-check mr-1"></i>
                        {{ isset($user) ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@stop
