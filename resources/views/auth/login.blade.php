@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ url('/login') }}">
    {!! csrf_field() !!}
    <div class="panel panel-body login-form">
        <div class="text-center">
            @include('auth._logo_block')
            <h5>{{ trans('auth.login_to_your_account') }}</h5>
            <h6>Или пройдите <a href="{{ url('/register') }}">регистрацию</a></h6>
        </div>

        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user'])
        @include('_input_block',['name' => 'password', 'type' => 'password', 'placeholder' => trans('auth.password'), 'icon' => 'icon-lock2'])
        @include('auth._re_capcha_block')

        <div class="form-group login-options">
            <div class="row">
                @include('_checkbox_block', ['name' => 'remember', 'checked' => true, 'label' => trans('auth.remember_me'), 'col' => 6])
                <div class="col-md-6 col-sm-6 col-xs-6 text-right" style="margin-top: 0; padding-left: 0;">
                    <a href="{{ url('/password/reset') }}">{{ trans('auth.forgot_your_password') }}</a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center" style="margin-top: 15px;">
                    <a href="{{ url('/send-confirm-mail') }}">{{ trans('auth.re_confirmation') }}</a>
                </div>
            </div>
        </div>

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-orange-800 btn-block', 'text' => trans('content.enter'), 'icon' => 'icon-circle-right2 position-right'])
            @include('auth._back_home_block')
        </div>
    </div>
</form>
@endsection