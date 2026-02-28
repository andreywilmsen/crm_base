@extends('adminlte::page')

@section('title', 'Registros Financeiros')

@section('content_header')
    <h1>Lista de Registros</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('record.create') }}" class="btn btn-primary shadow-sm px-3">
                    <i class="fas fa-plus-circle mr-1"></i> Novo Registro
                </a>

                <div>
                    <a href="{{ route('record-category.index') }}" class="btn btn-default border shadow-sm mr-2 text-dark">
                        <i class="fas fa-tags text-primary mr-1"></i> Categorias
                    </a>

                    <a href="{{ route('record-status.index') }}" class="btn btn-default border shadow-sm text-dark">
                        <i class="fas fa-stream text-info mr-1"></i> Status
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <x-core::dynamic-table :columns="$columns" :records="$records" editRoute="record.show"
                deleteRoute="record.destroy" />
        </div>
    </div>
@stop
