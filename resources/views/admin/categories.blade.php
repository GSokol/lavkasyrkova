@extends('layouts.admin')

@section('content')
    @include('admin._modal_delete_block',['modalId' => 'delete-modal', 'function' => 'delete-product', 'head' => 'Вы действительно хотите удалить этот продукт?'])
    {{ csrf_field() }}

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Категории</h3>
        </div>
        <div class="panel-body">
            <table class="table datatable-basic table-items">
                <tr>
                    <th class="id">id</th>
                    <th class="text-center">Изображение</th>
                    <th class="text-center">Название</th>
                    <th class="text-center">Дата добавления/редактирования</th>
                    <th class="text-center"></th>
                </tr>
                @foreach ($categories as $category)
                    <tr role="row" id="{{ 'category_'.$category->id }}">
                        <td class="id">{{ $category->id }}</td>
                        <td class="text-center image"><a class="img-preview" href="{{ asset($category->image) }}"><img src="{{ asset($category->image) }}" /></a></td>
                        <td class="text-center"><a href="{{ route('admin.category', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
                        <td class="text-center">дата</td>
                        <td class="delete"><span del-data="{{ $category->id }}" modal-data="delete-modal" class="glyphicon glyphicon-remove-circle"></span></td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
