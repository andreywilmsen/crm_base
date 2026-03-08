@extends('adminlte::page')

@section('title', 'Colaboradores')

@section('content_header')
    <h1>Lista de Colaboradores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('collaborator.create') }}" class="btn btn-primary shadow-sm px-3">
                    <i class="fas fa-plus-circle mr-1"></i> Novo Colaborador
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <x-core::dynamic-table :columns="$columns" :records="$records" editRoute="collaborator.show"
                deleteRoute="collaborator.destroy" />
        </div>
    </div>
@stop
