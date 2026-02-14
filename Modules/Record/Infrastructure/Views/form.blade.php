@extends('adminlte::page')

@section('title', isset($record) ? 'Editar Registro' : 'Novo Registro')

@section('content_header')
    <h1>{{ isset($record) ? 'Editar Registro' : 'Novo Registro' }}</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Erro!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Registro Financeiro</h3>
        </div>

        <form action="{{ isset($record) ? route('record.update', $record['id']) : route('record.store') }}" method="POST">
            @csrf
            @if (isset($record))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="row">
                    {{-- Título --}}
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Título do Registro</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $record['title'] ?? '') }}"
                                placeholder="Ex: Venda de Consultoria" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Valor --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="value">Valor (R$)</label>
                            <input type="number" step="0.01" name="value"
                                class="form-control @error('value') is-invalid @enderror" id="value"
                                value="{{ old('value', $record['value'] ?? '') }}" placeholder="0,00" required>
                            @error('value')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Data de Referência --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reference_date">Data de Referência</label>
                            <input type="date" name="reference_date"
                                class="form-control @error('reference_date') is-invalid @enderror" id="reference_date"
                                value="{{ old('reference_date', $record['reference_date'] ?? date('Y-m-d')) }}" required>
                            @error('reference_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="pending"
                                    {{ old('status', $record['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pendente
                                </option>
                                <option value="completed"
                                    {{ old('status', $record['status'] ?? '') == 'completed' ? 'selected' : '' }}>
                                    Concluído</option>
                                <option value="canceled"
                                    {{ old('status', $record['status'] ?? '') == 'canceled' ? 'selected' : '' }}>
                                    Cancelado</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Descrição --}}
                <div class="form-group">
                    <label for="description">Descrição / Observações</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                        rows="3" placeholder="Detalhes do registro...">{{ old('description', $record['description'] ?? '') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Oculto para o User ID (Associa ao usuário logado se for novo) --}}
                @if (!isset($record))
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                @endif
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('record.index') }}" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($record) ? 'Atualizar Registro' : 'Salvar Registro' }}
                </button>
            </div>
        </form>
    </div>
@stop
