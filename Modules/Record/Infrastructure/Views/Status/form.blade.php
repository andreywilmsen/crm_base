@extends('adminlte::page')

@php
    $isEdit = isset($status);
    $title = $isEdit ? 'Editar Status' : 'Novo Status';
    $route = $isEdit ? route('record-status.update', $status->getId()) : route('record-status.store');
@endphp

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card {{ $isEdit ? 'card-info' : 'card-primary' }}">
                <div class="card-header">
                    <h3 class="card-title">{{ $isEdit ? 'ID: ' . $status->getId() : 'Preencha os dados abaixo' }}</h3>
                </div>

                <form action="{{ $route }}" method="POST">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nome do Status</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $isEdit ? $status->getName() : '') }}"
                                placeholder="Ex: Vendas, Despesas Fixas..." required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn {{ $isEdit ? 'btn-info' : 'btn-primary' }}">
                            <i class="fas fa-save"></i> {{ $isEdit ? 'Atualizar' : 'Cadastrar' }}
                        </button>
                        <a href="{{ route('record-status.index') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
