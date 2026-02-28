@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Lista de Usuários</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('user.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle"></i> Novo Usuário
            </a>
        </div>

        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="icon fas fa-check"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <x-core::dynamic-table :columns="$columns" :records="$records" editRoute="user.show" deleteRoute="user.destroy" />
        </div>
    </div>
@stop
