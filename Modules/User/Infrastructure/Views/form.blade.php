@extends('adminlte::page')

@section('title', isset($user) ? 'Editar Usuário' : 'Novo Usuário')

@section('content_header')
    <h1>{{ isset($user) ? 'Editar Usuário' : 'Novo Usuário' }}</h1>
@stop

@section('content')
    {{-- Alertas de Erro ou Sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-ban"></i> {{ $errors->first('error') }}
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Usuário</h3>
        </div>
        
        {{-- Formulário Principal --}}
        <form action="{{ isset($user) ? route('user.update', $user['id']) : route('user.store') }}" method="POST">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           id="name" value="{{ old('name', $user['name'] ?? '') }}" placeholder="Digite o nome" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" value="{{ old('email', $user['email'] ?? '') }}" placeholder="usuario@email.com" required>
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="role">Perfil de Acesso</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Selecione um perfil...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                {{ (old('role') == $role->name || (isset($user) && ($user['role'] ?? '') == $role->name)) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                @if(!isset($user))
                    <div class="form-group">
                        <label for="password">Senha Inicial</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" placeholder="Digite a senha inicial" required>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                @else
                    <div class="form-group mt-4">
                        <label>Segurança</label>
                        <br>
                        {{-- Botão com a classe para o SweetAlert --}}
                        <button type="button" class="btn btn-warning btn-reset-password">
                            <i class="fas fa-sync"></i> Resetar Senha para Padrão
                        </button>
                        <p class="text-muted mt-2"><small>A senha voltará para o padrão definido no sistema.</small></p>
                    </div>
                @endif
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('user.index') }}" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($user) ? 'Atualizar' : 'Salvar' }}
                </button>
            </div>
        </form>
    </div>
    @if(isset($user))
        <form id="form-reset" action="{{ route('user.reset-password', $user['id']) }}" method="POST" style="display:none;">
            @csrf
            @method('PUT')
        </form>
    @endif
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
                    confirmButtonColor: '#f39c12',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, resetar agora!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $('#form-reset');
                        if (form.length) {
                            form.submit();
                        } else {
                            Swal.fire('Erro!', 'Formulário de reset não encontrado no HTML.', 'error');
                        }
                    }
                });
            });
        });
    </script>
@stop