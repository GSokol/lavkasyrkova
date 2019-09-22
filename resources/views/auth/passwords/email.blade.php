@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    {!! csrf_field() !!}
    <div class="panel panel-body login-form">
        <div class="text-center">
            <div><img class="logo" src="{{ asset('images/logo.svg') }}"></div>
            <h5 class="content-group-lg">{{ trans('auth.reset_password') }} <small class="display-block">{!! trans('auth.reset_password_head') !!}</small></h5>
        </div>

        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user'])

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-orange-800 btn-block', 'text' => trans('auth.send_password_reset_link'), 'icon' => 'icon-circle-right2 position-right'])
        </div>
    </div>
</form>
@endsection
