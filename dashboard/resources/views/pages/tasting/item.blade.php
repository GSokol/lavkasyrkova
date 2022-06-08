@extends('dashboard::layouts.default')

@section('content')
    @if (isset($tasting))
        @include('admin._modal_delete_block', ['modalId' => 'delete-user-modal', 'function' => 'delete-tasting-user', 'head' => 'Вы действительно хотите удалить этого участника дегустации?'])
    @endif

    <div class="panel-heading">
        <h4 class="panel-title">{{ isset($tasting) ? $tasting->name : 'Добавление дегустации' }}</h4>
    </div>
    <form class="form-horizontal complex-form" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        @if (isset($tasting))
            <input type="hidden" name="id" value="{{ $tasting->id }}">
        @endif

        <div class="panel panel-flat">
            <div class="panel-heading">
                <h4 class="panel-title">Дегустация</h4>
            </div>
            <div class="panel-body">
                @include('admin._select_block',[
                    'label' => 'Место проведения дегустации',
                    'name' => 'office_id',
                    'values' => $offices,
                    'selected' => isset($tasting) ? $tasting->office_id : 1
                ])

                @include('_date_block', [
                    'label' => 'Время проведения дегустации',
                    'name' => 'time',
                    'value' => isset($tasting) ? $tasting->time : time() + (60*60*24*7),
                ])

                <div class="panel panel-flat">
                    <div class="panel-body">
                        @include('admin._checkbox_block',[
                            'label' => 'Дегустация активна',
                            'name' => 'active',
                            'checked' => isset($tasting) ? $tasting->active : true
                        ])
                    </div>
                </div>
            </div>
        </div>

        @if (isset($tasting))
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h4 class="panel-title">Участники дегустации</h4>
                </div>
                <div class="panel-body">
                    @if (count($tasting->tastingToUsers))
                        @include('admin._users_table_block', ['users' => $tasting->tastingToUsers])
                    @else
                        <h2 class="text-center">Нет участников</h2>
                    @endif
                </div>
            </div>
        @endif

        @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
    </form>
@endsection
