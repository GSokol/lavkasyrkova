@extends('dashboard::layouts.default')

@section('content')
    @include('admin._modal_delete_block',['modalId' => 'delete-modal', 'function' => 'delete-product', 'head' => 'Вы действительно хотите удалить этот продукт?'])
    {{ csrf_field() }}

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h2 class="panel-title">Продукты</h2>
        </div>
    </div>

    @foreach($categories as $category)
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $category->name }}</h3>
            </div>
            <div class="panel-body">
                <table class="table datatable-basic table-items">
                    <tr>
                        <th class="id">id</th>
                        <th class="text-center">Изображение</th>
                        <th class="text-center">Название</th>
                        <th class="text-center">Цена за целое</th>
                        <th class="text-center">Цена за {{ Helper::getProductParts()[0].Helper::getPartsName() }}</th>
                        <th class="text-center">Акционный товар</th>
                        <th class="text-center">Статус</th>
                        <th class="text-center">Удалить</th>
                    </tr>
                    @foreach ($category->products as $product)
                        <tr role="row" id="{{ 'product_'.$product->id }}">
                            <td class="id">{{ $product->id }}</td>
                            <td class="text-center image"><a class="img-preview" href="{{ asset($product->image) }}"><img src="{{ asset($product->image) }}" onerror="this.src='/images/default.jpg'" /></a></td>
                            <td class="text-center"><a href="{{ route('dashboard.product', ['id' => $product->id]) }}">{{ $product->name }}</a></td>
                            <td class="text-center">{{ number_format($product->whole_price, 0, '', ' ').'р.' }}</td>
                            <td class="text-center">{{ number_format($product->part_price, 0, '', ' ').'р.' }}</td>
                            <td class="text-center">@include('admin._status_block',['status' => $product->action, 'trueLabel' => 'Да', 'falseLabel' => 'Нет'])</td>
                            <td class="text-center">@include('admin._status_block',['status' => $product->active, 'trueLabel' => 'активен', 'falseLabel' => 'не активен'])</td>
                            <td class="delete"><span del-data="{{ $product->id }}" modal-data="delete-modal" class="glyphicon glyphicon-remove-circle"></span></td>
                        </tr>
                    @endforeach
                </table>
                @include('admin._add_button_block',['href' => 'products/add?category_id='.$category->id, 'text' => 'Добавить продукт'])
            </div>
        </div>
    @endforeach
@endsection
