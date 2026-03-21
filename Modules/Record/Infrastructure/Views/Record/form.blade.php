@extends('adminlte::page')

@section('title', isset($record) ? 'Editar Registro' : 'Novo Registro')

@section('content_header')
    <div class="d-flex align-items-center">
        <a href="{{ route('record.index') }}" class="btn btn-default btn-sm border shadow-sm mr-3">
            <i class="fas fa-arrow-left text-muted"></i>
        </a>
        <h1 class="m-0 text-dark">{{ isset($record) ? 'Editar Registro' : 'Novo Registro' }}</h1>
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
                @if (isset($record))
                    <div class="card-tools">
                        <span class="badge badge-light border text-secondary px-2 py-1">ID #{{ $record->id }}</span>
                    </div>
                @endif
            </div>

            <form action="{{ isset($record) ? route('record.update', $record->id) : route('record.store') }}"
                method="POST">
                @csrf
                @if (isset($record))
                    @method('PUT')
                @endif

                <div class="card-body bg-light-50">
                    <div class="row">
                        {{-- Título --}}
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="small text-uppercase text-muted font-weight-bold">Título do
                                    Registro</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-heading text-light"></i></span>
                                    </div>
                                    <input type="text" name="title"
                                        class="form-control border-left-0 shadow-none @error('title') is-invalid @enderror"
                                        id="title" value="{{ old('title', $record->title ?? '') }}"
                                        placeholder="Ex: Venda de Consultoria" required>
                                </div>
                                @error('title')
                                    <span class="invalid-feedback d-block small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Valor --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="value" class="small text-uppercase text-muted font-weight-bold">Valor
                                    (R$)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span
                                            class="input-group-text bg-white border-right-0 text-muted font-weight-bold">R$</span>
                                    </div>
                                    <input type="number" step="0.01" name="value"
                                        class="form-control border-left-0 shadow-none font-weight-bold text-primary @error('value') is-invalid @enderror"
                                        id="value" value="{{ old('value', $record->value ?? '') }}" placeholder="0,00">
                                </div>
                                @error('value')
                                    <span class="invalid-feedback d-block small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        {{-- Data --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference_date" class="small text-uppercase text-muted font-weight-bold">Data de
                                    Referência</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="far fa-calendar-alt text-light"></i></span>
                                    </div>
                                    <input type="date" name="reference_date"
                                        class="form-control border-left-0 shadow-none @error('reference_date') is-invalid @enderror"
                                        id="reference_date"
                                        value="{{ old('reference_date', isset($record->referenceDate) ? \Carbon\Carbon::parse($record->referenceDate)->format('Y-m-d') : date('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Categoria --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id"
                                    class="small text-uppercase text-muted font-weight-bold">Categoria</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-layer-group text-light"></i></span>
                                    </div>
                                    <select name="category_id" id="category_id"
                                        class="form-control border-left-0 shadow-none @error('category_id') is-invalid @enderror"
                                        required>
                                        <option value="">Selecione...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->getId() }}"
                                                {{ old('category_id', $record->categoryId ?? '') == $category->getId() ? 'selected' : '' }}>
                                                {{ $category->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status_id"
                                    class="small text-uppercase text-muted font-weight-bold">Status</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-check-double text-light"></i></span>
                                    </div>
                                    <select name="status_id" id="status"
                                        class="form-control border-left-0 shadow-none @error('status_id') is-invalid @enderror"
                                        required>
                                        <option value="">Selecione...</option>
                                        @foreach ($status as $item)
                                            <option value="{{ $item->getId() }}"
                                                {{ old('status_id', $record->statusId ?? '') == $item->getId() ? 'selected' : '' }}>
                                                {{ $item->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="form-group mt-2">
                        <label for="description" class="small text-uppercase text-muted font-weight-bold">Descrição /
                            Observações</label>
                        <textarea name="description" class="form-control shadow-none @error('description') is-invalid @enderror"
                            id="description" rows="3" placeholder="Detalhes adicionais...">{{ old('description', $record->description ?? '') }}</textarea>
                    </div>

                    {{-- SEÇÃO DE ANEXOS --}}
                    <div class="form-group mt-4">
                        <label class="small text-uppercase text-muted font-weight-bold">Anexos</label>
                        <div class="border rounded p-3 bg-white shadow-sm">
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" id="attachmentInput"
                                    data-url="{{ route('attachments.store') }}" data-owner-id="{{ $record->id ?? 0 }}"
                                    data-owner-type="record">
                                <label class="custom-file-label" for="attachmentInput">Selecionar arquivo...</label>
                            </div>

                            <div id="attachmentList" class="list-group list-group-flush">
                                @forelse ($record->attachments ?? [] as $file)
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2"
                                        id="file-{{ $file['id'] }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-alt text-primary mr-3 fa-lg"></i>
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-bold text-dark"
                                                    style="font-size: 0.85rem;">{{ $file['name'] }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">Enviado em:
                                                    {{ \Carbon\Carbon::parse($file['created_at'])->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ asset('storage/' . $file['path']) }}"
                                                download="{{ $file['name'] }}"
                                                class="btn btn-sm btn-light border shadow-sm mr-1">
                                                <i class="fas fa-download text-primary"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-sm btn-light border shadow-sm btn-delete-file"
                                                data-id="{{ $file['id'] }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div id="no-attachments-message" class="text-center py-3">
                                        <p class="text-muted small mb-0">Nenhum anexo disponível.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @section('js')
                        <script src="{{ asset('js/attachments.js') }}"></script>
                        <script>
                            $(document).ready(function() {
                                initAttachmentManager({
                                    inputSelector: '#attachmentInput',
                                    listSelector: '#attachmentList',
                                    csrfToken: '{{ csrf_token() }}'
                                });
                            });
                        </script>
                    @stop

                    @if (isset($record))
                        <div class="mt-4 p-3 bg-white border rounded d-flex align-items-center justify-content-between">
                            <span class="small text-muted italic"><i class="fas fa-history mr-1"></i> Histórico</span>
                            <span class="small font-weight-bold text-secondary">Editado por:
                                {{ $record->username }}</span>
                        </div>
                    @else
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endif
                </div>

                <div class="card-footer bg-white border-top text-right py-3">
                    <a href="{{ route('record.index') }}" class="btn btn-default border shadow-sm px-3 mr-1 text-dark">
                        <i class="fas fa-times mr-1 text-muted"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm px-3">
                        <i class="fas fa-check mr-1"></i> {{ isset($record) ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/attachments.js') }}"></script>
    <script>
        $(function() {
            if ($('#attachmentInput').length > 0 && !$('#attachmentInput').is(':disabled')) {
                initAttachmentManager({
                    inputSelector: '#attachmentInput',
                    listSelector: '#attachmentList',
                    csrfToken: '{{ csrf_token() }}'
                });
            }
        });
    </script>
@stop
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/attachments.js') }}"></script>
