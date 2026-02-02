@extends('adminlte::page')

@section('title', isset($user) ? 'Editar Usuário' : 'Novo Usuário')

@section('content_header')
    <h1>{{ isset($user) ? 'Editar Usuário' : 'Novo Usuário' }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Usuário</h3>
        </div>
        
        <form action="{{ isset($user) ? route('user.update', $user['id']) : route('user.store') }}" method="POST">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="card-body">
                {{-- Nome --}}
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           id="name" value="{{ old('name', $user['name'] ?? '') }}" placeholder="Digite o nome" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                {{-- E-mail --}}
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" value="{{ old('email', $user['email'] ?? '') }}" placeholder="usuario@email.com" required>
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                {{-- Perfil de Acesso (Roles) --}}
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

                {{-- Lógica da Senha --}}
                @if(!isset($user))
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" placeholder="Digite a senha inicial" required>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> A senha não pode ser alterada por este módulo administrativo. O usuário deve alterá-la em seu próprio perfil.
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
@stop