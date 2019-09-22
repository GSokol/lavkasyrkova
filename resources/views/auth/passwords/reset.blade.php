@extends('layouts.auth')

@section('content')
<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="panel panel-body login-form">
        <div class="text-center">
            <div><img class="logo" src="{{ asset('images/logo.svg') }}"></div>
            <h5 class="content-group-lg">{{ trans('auth.reset_password') }} <small class="display-block">{!! trans('auth.new_password_head') !!}</small></h5>
        </div>

        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user', 'value' => $email])
        @include('_input_block',['name' => 'password', 'type' => 'password', 'placeholder' => trans('auth.password'), 'icon' => 'icon-lock2'])
        @include('_input_block',['name' => 'password_confirmation', 'type' => 'password', 'placeholder' => trans('auth.password_confirm'), 'icon' => 'icon-lock2'])

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-orange-800 btn-block', 'text' => trans('auth.save_new_password'), 'icon' => 'icon-circle-right2 position-right'])
        </div>
    </div>
</form>
@endsection
