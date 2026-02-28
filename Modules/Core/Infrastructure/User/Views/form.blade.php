@extends('adminlte::page')

@section('title', isset($user) ? 'Editar Usuário' : 'Novo Usuário')

@section('content_header')
    <div class="d-flex align-items-center">
        <a href="{{ route('user.index') }}" class="btn btn-default btn-sm border shadow-sm mr-3">
            <i class="fas fa-arrow-left text-muted"></i>
        </a>
        <h1 class="m-0 text-dark">{{ isset($user) ? 'Editar Usuário' : 'Novo Usuário' }}</h1>
    </div>
@stop

@section('content')
    <div class="mt-3">
        {{-- Alertas Padronizados --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm border-0 fade show" role="alert">
                <i class="icon fas fa-check mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 fade show" role="alert">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="card-title text-muted">
                    <i class="fas fa-user-shield mr-2"></i>
                    <span class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px; font-weight: 700;">
                        Dados de Acesso e Perfil
                    </span>
                </h3>
                <div class="card-tools">
                    @if (isset($user))
                        <span class="badge badge-light border text-secondary px-2 py-1">ID #{{ $user['id'] }}</span>
                    @endif
                </div>
            </div>

            <form action="{{ isset($user) ? route('user.update', $user['id']) : route('user.store') }}" method="POST">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <div class="card-body py-4 bg-light-50">
                    <div class="row">
                        {{-- Nome --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nome Completo</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name', $user['name'] ?? '') }}" placeholder="Ex: João Silva"
                                        required>
                                </div>
                            </div>
                        </div>

                        {{-- E-mail --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail Corporativo</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        value="{{ old('email', $user['email'] ?? '') }}" placeholder="usuario@empresa.com"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        {{-- Perfil de Acesso --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Nível de Permissão</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <select name="role" id="role"
                                        class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">Selecione...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ old('role') == $role->name || (isset($user) && ($user['role'] ?? '') == $role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Senhas ou Botão de Reset --}}
                        @if (!isset($user))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password">Senha Inicial</label>
                                    <input type="password" name="password"
                                        class="form-control form-control-sm @error('password') is-invalid @enderror"
                                        id="password" placeholder="******" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-sm"
                                        id="password_confirmation" placeholder="******" required>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Segurança da Conta</label><br>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-warning btn-reset-password shadow-sm px-3">
                                        <i class="fas fa-key mr-1"></i> Resetar Senha para Padrão
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Rodapé Padronizado --}}
                <div class="card-footer bg-white border-top text-right py-3">
                    <a href="{{ route('user.index') }}" class="btn btn-default border shadow-sm px-3 mr-1 text-dark">
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

    @if (isset($user))
        <form id="form-reset" action="{{ route('user.reset-password', $user['id']) }}" method="POST"
            style="display:none;">
            @csrf @method('PUT')
        </form>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.btn-reset-password').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Resetar Senha?',
                    text: "O acesso atual será perdido e a senha voltará ao padrão do sistema!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, resetar agora!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) $('#form-reset').submit();
                });
            });
        });
    </script>
@stop
