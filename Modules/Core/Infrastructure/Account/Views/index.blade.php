@extends('adminlte::page')

@section('title', 'Meu Perfil')

@section('content_header')
    <h1>Meu Perfil</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informações da Conta</h3>
                </div>

                <form action="{{ route('account.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- Exibição de Mensagens de Sucesso --}}
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Exibição de Erros Gerais --}}
                        @if($errors->has('error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="name">Nome completo</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" value="{{ old('name', $user->getName()) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" value="{{ old('email', $user->getEmail()) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <p class="text-muted">Deixe os campos abaixo em branco caso não queira alterar a senha.</p>

                        <div class="form-group">
                            <label for="password">Nova Senha</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" placeholder="Mínimo 8 caracteres">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   id="password_confirmation">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Resumo</h3>
                </div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->getName()) }}&size=128" 
                         class="img-circle elevation-2 mb-3" alt="User Image">
                    <h5>{{ $user->getName() }}</h5>
                    <p class="text-muted">Nível: {{ ucfirst($user->getRole()) }}</p>
                </div>
            </div>
        </div>
    </div>
@stop