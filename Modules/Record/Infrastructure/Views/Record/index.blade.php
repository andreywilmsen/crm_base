@extends('adminlte::page')

@section('title', 'Registros Financeiros')

@section('content_header')
    <h1>Lista de Registros</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('record.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle"></i> Novo Registro
            </a>
            <a href="{{ route('record-category.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-tags"></i> Categorias
            </a>
            <a href="{{ route('record-status.index') }}" class="btn btn-info shadow-sm">
                <i class="fas fa-stream"></i> Status
            </a>
        </div>
        <div class="card-body p-0">
            <x-core::table-handler :columns="$columns" :records="$records" :routes="[
                'index' => route('record.index'),
                'edit' => 'record.show',
                'delete' => 'record.destroy',
            ]" />
        </div>
    </div>
@stop
