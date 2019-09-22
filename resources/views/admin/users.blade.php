@extends('layouts.admin')

@section('content')
    @if (Auth::user()->is_admin)
        @include('admin._modal_delete_block',['modalId' => 'delete-user-modal', 'function' => 'delete-user', 'head' => 'Вы действительно хотите удалить этого пользователя?'])
        {{ csrf_field() }}
    @endif

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Пользователи</h3>
        </div>
        <div class="panel-body">
            @include('admin._users_table_block', ['users' => $data['users']])
            @if (Auth::user()->is_admin)
                @include('admin._add_button_block',['href' => 'users/add', 'text' => 'Добавить пользователя'])
            @endif
        </div>
    </div>
@endsection