@extends('admin.layouts.default')

@section('content')
<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-title">{{ isset($data['category']) ? $data['category']->name : 'Новая категория' }}</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('admin.postCategory', ['id' => $data['category']->name  ?: 'new']) }}" method="post">
            {{ csrf_field() }}
            @if (isset($data['category']))
                <input type="hidden" name="id" value="{{ $data['category']->id }}">
            @endif

            <div class="col-md-3 col-sm-12 col-xs-12">
                @include('admin._image_block', [
                    'col' => 12,
                    'preview' => isset($data['category']) && $data['category']->image ? $data['category']->image : null,
                    'name' => 'image',
                    'label' => 'Изображение',
                ])
            </div>

            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        @include('_input_block', [
                            'label' => 'Название',
                            'name' => 'name',
                            'type' => 'text',
                            'max' => 255,
                            'placeholder' => 'Название продукта',
                            'value' => isset($data['category']) ? $data['category']->name : ''
                        ])

                        @include('_input_block', [
                            'label' => 'Ссылка',
                            'name' => 'slug',
                            'type' => 'text',
                            'max' => 255,
                            'placeholder' => 'Ссылка категории',
                            'value' => isset($data['category']) ? $data['category']->slug : ''
                        ])
                    </div>
                </div>
                @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
            </div>
        </form>
    </div>
</div>

@if (isset($data['user']))
    @include('admin._orders_block',['orders' => $data['user']->orders, 'user' => $data['user']])
@endif

@endsection
