@extends('dashboard::layouts.default')

@section('content')
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8">
                <h3 class="panel-title">{{ $category->name ?: 'Новая категория' }}</h3>
            </div>
            <div class="col-md-4 text-right">
                <a class="btn bg-success-600" href="{{ route('dashboard.category', ['id' => 'new']) }}"><i class="icon-add"></i> Добавить категорию</a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('dashboard.postCategory', ['id' => $category->name  ?: 'new']) }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $category->id }}">

            <div class="col-md-3 col-sm-12 col-xs-12">
                @include('admin._image_block', [
                    'col' => 12,
                    'preview' => isset($category) && $category->image ? $category->image : null,
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
                            'value' => isset($category) ? $category->name : ''
                        ])

                        @include('_input_block', [
                            'label' => 'Ссылка',
                            'name' => 'slug',
                            'type' => 'text',
                            'max' => 255,
                            'placeholder' => 'Ссылка категории',
                            'value' => isset($category) ? $category->slug : ''
                        ])
                    </div>
                </div>
                @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
            </div>
        </form>
    </div>
</div>
@endsection
