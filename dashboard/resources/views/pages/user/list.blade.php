@extends('dashboard::layouts.default')

@section('content')
    @if (Auth::user()->is_admin)
        @include('admin._modal_delete_block', ['modalId' => 'delete-user-modal', 'function' => 'delete-user', 'head' => 'Вы действительно хотите удалить этого пользователя?'])
        {{ csrf_field() }}
    @endif

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Пользователи</h3>
        </div>
        <div class="panel-body">
            @include('admin._users_table_block', ['users' => $users])

            <div class="text-right">
                <a class="btn bg-success-600" href="{{ route('dashboard.user', ['id' => 'new']) }}">
                    <i class="icon-add-to-list mr-10"></i>Добавить пользователя
                </a>
            </div>
        </div>
    </div>
@endsection
