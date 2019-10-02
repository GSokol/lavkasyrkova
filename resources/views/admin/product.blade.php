@extends('layouts.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h4 class="panel-title">{{ isset($data['product']) ? $data['product']->name : 'Добавление продукта' }}</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/admin/product') }}" method="post">
                {{ csrf_field() }}
                @if (isset($data['product']))
                    <input type="hidden" name="id" value="{{ $data['product']->id }}">
                @endif

                <div class="col-md-3 col-sm-12 col-xs-12">
                    @include('admin._image_block',[
                        'col' => 12,
                        'preview' => isset($data['product']) && $data['product']->big_image ? $data['product']->big_image : null,
                        'name' => 'big_image',
                        'label' => 'Большая картинка'
                    ])
                    @include('admin._image_block',[
                        'col' => 12,
                        'preview' => isset($data['product']) ? $data['product']->image : null
                    ])
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            @include('admin._select_block',[
                                'label' => 'Категория товара',
                                'name' => 'category_id',
                                'values' => $data['categories'],
                                'selected' => isset($data['product']) ? $data['product']->category_id : (Request::has('category_id') && Request::input('category_id') ? Request::input('category_id') : 1)
                            ])

                            @include('admin._select_block',[
                                'label' => 'Под-категория товара',
                                'name' => 'add_category_id',
                                'values' => $data['add_categories'],
                                'selected' => isset($data['product']) ? $data['product']->add_category_id : 1
                            ])

                            @include('_input_block', [
                                'label' => 'Название',
                                'name' => 'name',
                                'type' => 'text',
                                'max' => 255,
                                'placeholder' => 'Название продукта',
                                'value' => isset($data['product']) ? $data['product']->name : ''
                            ])

                            @include('admin._textarea_block', [
                                'label' => 'Описание',
                                'name' => 'description',
                                'simple' => true,
                                'value' => isset($data['product']) ? $data['product']->description : ''
                            ])

                            @include('_input_value_block', [
                                'label' => 'Цена за целое',
                                'name' => 'whole_price',
                                'min' => 100,
                                'max' => 100000,
                                'unit' => 'р.',
                                'differentially' => false,
                                'price' => 0,
                                'increment' => 100,
                                'value' => isset($data['product']) ? $data['product']->whole_price : 100
                            ])

                            @include('_input_value_block', [
                                'label' => 'Цена за целое по акции',
                                'name' => 'action_whole_price',
                                'min' => 100,
                                'max' => 100000,
                                'unit' => 'р.',
                                'differentially' => false,
                                'price' => 0,
                                'increment' => 100,
                                'value' => isset($data['product']) ? $data['product']->action_whole_price : 100
                            ])

                            @include('_input_value_block', [
                                'label' => 'Цена за '.Helper::getProductParts()[0].Helper::getPartsName(),
                                'name' => 'part_price',
                                'min' => 100,
                                'max' => 100000,
                                'unit' => 'р.',
                                'differentially' => false,
                                'price' => 0,
                                'increment' => 100,
                                'value' => isset($data['product']) ? $data['product']->part_price : 100
                            ])

                            @include('_input_value_block', [
                                'label' => 'Цена за '.Helper::getProductParts()[0].Helper::getPartsName().' по акции',
                                'name' => 'action_part_price',
                                'min' => 100,
                                'max' => 100000,
                                'unit' => 'р.',
                                'differentially' => false,
                                'price' => 0,
                                'increment' => 100,
                                'value' => isset($data['product']) ? $data['product']->action_part_price : 100
                            ])

                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    @include('admin._checkbox_block',[
                                        'label' => 'Торгуется на развес',
                                        'name' => 'parts',
                                        'checked' => isset($data['product']) ? $data['product']->parts : false
                                    ])

                                    @include('admin._checkbox_block',[
                                        'label' => 'Продукт активен',
                                        'name' => 'active',
                                        'checked' => isset($data['product']) ? $data['product']->active : true
                                    ])

                                    @include('admin._checkbox_block',[
                                        'label' => 'Акционный продукт',
                                        'name' => 'action',
                                        'checked' => isset($data['product']) ? $data['product']->action : false
                                    ])
                                </div>
                            </div>
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