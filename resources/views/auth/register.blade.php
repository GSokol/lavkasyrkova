@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ url('/register') }}">
    {!! csrf_field() !!}
    <div class="panel panel-body login-form">
        <div class="text-center">
            @include('auth._logo_block')
            <h5 class="content-group-lg">{{ trans('auth.register') }} <small class="display-block">{!! trans('auth.register_head') !!}</small></h5>
        </div>

        @include('_input_block',['name' => 'phone', 'type' => 'tel', 'placeholder' => trans('auth.phone'), 'icon' => 'glyphicon glyphicon-phone'])
        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user'])
        @include('_input_block',['name' => 'password', 'type' => 'password', 'placeholder' => trans('auth.password'), 'icon' => 'icon-lock2'])
        @include('_input_block',['name' => 'password_confirmation', 'type' => 'password', 'placeholder' => trans('auth.password_confirm'), 'icon' => 'icon-lock2'])

        <h6 class="text-center">Укажите ваш офис:</h6>
        @include('admin._select_block',[
            'name' => 'office_id',
            'values' => $offices,
            'selected' => 1
        ])

        @include('auth._re_capcha_block')

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-orange-800 btn-block', 'text' => trans('auth.register'), 'icon' => 'icon-circle-right2 position-right'])
        </div>
    </div>
</form>
@endsection
