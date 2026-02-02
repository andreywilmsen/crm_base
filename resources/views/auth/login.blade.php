@extends('adminlte::auth.login')

@section('auth_header')
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="icon fas fa-info-circle"></i> {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @else
        <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
    @endif
@stop