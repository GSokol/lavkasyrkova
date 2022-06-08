@extends('dashboard::layouts.default')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h4 class="panel-title">{{ isset($user) ? 'Редактирование пользователя '.$user->email : 'Добавление пользователя' }}</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/profile/user') }}" method="post">
                {{ csrf_field() }}
                @if (isset($user))
                    <input type="hidden" name="id" value="{{ $user->id }}">
                @endif

                @if (Auth::user()->is_admin && ((isset($user) && $user->office_id) || !isset($user)))
                    @include('admin._select_block',[
                        'label' => 'Привязка к офису',
                        'name' => 'office_id',
                        'values' => $offices,
                        'selected' => isset($user) && $user->office_id ? $user->office_id : 1
                    ])
                @endif

                @include('_input_block', [
                    'label' => 'E-mail',
                    'name' => 'email',
                    'type' => 'email',
                    'max' => 100,
                    'placeholder' => 'E-mail пользователя',
                    'value' => isset($user) ? $user->email : ''
                ])

                @include('_input_block', [
                    'label' => 'Имя',
                    'name' => 'name',
                    'type' => 'text',
                    'max' => 255,
                    'placeholder' => 'Имя пользователя',
                    'value' => isset($user) ? $user->name : ''
                ])

                @include('_input_block', [
                    'label' => 'Телефон',
                    'name' => 'phone',
                    'type' => 'tel',
                    'placeholder' => 'Телефон пользователя',
                    'value' => isset($user) ? $user->phone : ''
                ])

                @include('_input_block', [
                    'label' => 'Адрес',
                    'name' => 'address',
                    'type' => 'text',
                    'placeholder' => 'Адрес для доставки',
                    'value' => isset($user) ? $user->address : ''
                ])

                @include('admin._select_block',[
                    'label' => 'Привязка к офису',
                    'name' => 'office_id',
                    'values' => $offices,
                    'selected' => isset($user) ? $user->office_id : ''
                ])

                <div class="panel panel-flat">
                    @if (isset($user))
                        <div class="panel-heading">
                            <h4 class="text-grey-300">Если вы не хотите менять пароль, то оставьте эти поля пустыми</h4>
                        </div>
                    @endif

                    <div class="panel-body">
                        @if (isset($user) && !Auth::user()->is_admin)
                            @include('_input_block', [
                                'label' => 'Старый пароль',
                                'name' => 'old_password',
                                'type' => 'password',
                                'max' => 50,
                                'placeholder' => 'Старый пароль пользователя',
                                'value' => ''
                            ])
                        @endif

                        @include('_input_block', [
                            'label' => 'Новый пароль',
                            'name' => 'password',
                            'type' => 'password',
                            'max' => 50,
                            'placeholder' => 'Пароль пользователя',
                            'value' => ''
                        ])

                        @include('_input_block', [
                            'label' => 'Подтверждение пароля',
                            'name' => 'password_confirmation',
                            'type' => 'password',
                            'max' => 50,
                            'placeholder' => 'Подтверждение пароля',
                            'value' => ''
                        ])

                    </div>
                </div>

                @include('admin._checkbox_block',[
                    'label' => 'Отправлять письма',
                    'name' => 'send_mail',
                    'checked' => isset($user) ? $user->send_mail : true
                ])

                @if (Auth::user()->is_admin)
                    @include('admin._checkbox_block',[
                        'label' => 'Пользователь активен',
                        'name' => 'active',
                        'checked' => isset($user) ? $user->active : true
                    ])

                    @include('admin._checkbox_block',[
                        'label' => 'Пользователь является админом',
                        'name' => 'is_admin',
                        'checked' => isset($user) ? $user->is_admin : false
                    ])
                @endif

                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
                </div>
            </form>
        </div>
    </div>

    @if (isset($user))
        @include('admin._orders_block',['orders' => $user->orders, 'user' => $user])
    @endif

@endsection
