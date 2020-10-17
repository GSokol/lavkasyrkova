@extends('admin.layouts.default')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h4 class="panel-title">Настройки</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/admin/settings') }}" method="post">
                {{ csrf_field() }}

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="panel-body">
                                @include('_input_block', [
                                    'label' => 'Основной E-mail администратора',
                                    'name' => 'email',
                                    'type' => 'email',
                                    'max' => 100,
                                    'placeholder' => 'Основной E-mail',
                                    'value' => Settings::getSettings()->email
                                ])

                                @include('_input_block', [
                                    'label' => 'Достака от…',
                                    'name' => 'delivery_limit',
                                    'type' => 'number',
                                    'max' => 1000000,
                                    'value' => Settings::getSettings()->delivery_limit
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
                </div>
            </form>
        </div>

    </div>
@endsection