@extends('layouts.admin')

@section('content')
    @if (isset($data['tasting']))
        @include('admin._modal_delete_block',['modalId' => 'delete-user-modal', 'function' => 'delete-tasting-user', 'head' => 'Вы действительно хотите удалить этого участника дегустации?'])
    @endif

    <div class="panel-heading">
        <h4 class="panel-title">{{ isset($data['tasting']) ? $data['tasting']->name : 'Добавление дегустации' }}</h4>
    </div>
    <form class="form-horizontal complex-form" enctype="multipart/form-data" action="{{ url('/admin/tasting') }}" method="post">
        {{ csrf_field() }}
        @if (isset($data['tasting']))
            <input type="hidden" name="id" value="{{ $data['tasting']->id }}">
        @endif

        <div class="panel panel-flat">
            <div class="panel-heading">
                <h4 class="panel-title">Дегустация</h4>
                @include('admin._heading_elements_block')
            </div>
            <div class="panel-body">
                @include('admin._select_block',[
                    'label' => 'Место проведения дегустации',
                    'name' => 'office_id',
                    'values' => $data['offices'],
                    'selected' => isset($data['tasting']) ? $data['tasting']->office_id : 1
                ])

                @include('_input_block', [
                    'label' => 'Название дегустации',
                    'name' => 'name',
                    'type' => 'text',
                    'max' => 255,
                    'placeholder' => 'Название дегустации',
                    'value' => isset($data['tasting']) ? $data['tasting']->name : ''
                ])

                @include('_date_block', [
                    'label' => 'Время проведения дегустации',
                    'name' => 'time',
                    'value' => isset($data['tasting']) ? $data['tasting']->time : time()+(60*60*24*7)
                ])

                <div class="panel panel-flat">
                    <div class="panel-body">
                        @include('admin._checkbox_block',[
                            'label' => 'Дегустация активна',
                            'name' => 'active',
                            'checked' => isset($data['tasting']) ? $data['tasting']->active : true
                        ])
                    </div>
                </div>
            </div>
        </div>

        @if (isset($data['tasting']))
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h4 class="panel-title">Участники дегустации</h4>
                    @include('admin._heading_elements_block')
                </div>
                <div class="panel-body">
                    @if (count($data['tasting']->tastingToUsers))
                        @include('admin._users_table_block', ['users' => $data['tasting']->tastingToUsers])
                    @else
                        <h2 class="text-center">Нет участников</h2>
                    @endif
                </div>
            </div>
        @endif

        @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
    </form>
@endsection