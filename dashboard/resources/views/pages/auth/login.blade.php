@extends('layouts.auth')

@section('content')
<form method="post">
    {!! csrf_field() !!}
    <div class="panel panel-body login-form">
        <div class="text-center">
            @include('auth._logo_block')
            <h5>Админ панель</h5>
        </div>

        @include('_input_block',['name' => 'email', 'type' => 'email', 'placeholder' => 'E-mail', 'icon' => 'icon-user'])
        @include('_input_block',['name' => 'password', 'type' => 'password', 'placeholder' => trans('auth.password'), 'icon' => 'icon-lock2'])

        <div class="form-group login-options">
            <div class="row">
                @include('_checkbox_block', ['name' => 'remember', 'checked' => true, 'label' => trans('auth.remember_me'), 'col' => 6])
            </div>
        </div>

        <div class="form-group">
            @include('_button_block', ['type' => 'submit', 'mainClass' => 'bg-orange-800 btn-block', 'text' => trans('content.enter'), 'icon' => 'icon-circle-right2 position-right'])
            @include('auth._back_home_block')
        </div>
    </div>
</form>
@endsection
