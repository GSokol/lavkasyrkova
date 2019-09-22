@extends('layouts.auth')

@section('content')
<form method="POST" action="/confirm-user">
    {!! csrf_field() !!}
    <div class="panel panel-body login-form">
        <div class="text-center">
            @include('auth._logo_block')
            <h5 class="content-group-lg">{{ trans('auth.confirm_mail') }} <small class="display-block">{!! trans('auth.confirm_mail_head') !!}</small></h5>
        </div>

        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user'])

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-orange-800 btn-block', 'text' => trans('auth.send_confirm_mail'), 'icon' => 'icon-circle-right2 position-right'])
        </div>
    </div>
</form>
@endsection