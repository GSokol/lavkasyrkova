@extends('admin.layouts.default')

@section('content')
    @include('admin._modal_delete_block', ['modalId' => 'delete-modal', 'function' => 'category/delete', 'head' => 'Вы действительно хотите удалить этот продукт?'])
    {{ csrf_field() }}

    <div class="panel panel-flat">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title">Категории</h3>
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn bg-success-600" href="{{ route('admin.category', ['id' => 'new']) }}"><i class="icon-add"></i> Добавить категорию</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-items">
                <tr>
                    <th class="id">id</th>
                    <th class="text-center">Изображение</th>
                    <th class="">Название</th>
                    <th class="">Ссылка</th>
                    <th class="">Дата редактирования</th>
                    <th class="text-center"></th>
                </tr>
                @foreach ($categories as $category)
                    <tr role="row" id="{{ 'category_'.$category->id }}">
                        <td class="id">{{ $category->id }}</td>
                        <td class="text-center image"><a class="img-preview" href="{{ asset($category->image) }}"><img src="{{ asset($category->image) }}" /></a></td>
                        <td class=""><a href="{{ route('admin.category', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
                        <td class=""><span>{{ $category->slug }}</span></td>
                        <td class=""><span>{{ $category->updated_at }}</span></td>
                        <td class="delete">
                            <span del-data="{{ $category->id }}" modal-data="delete-modal" class="glyphicon glyphicon-remove-circle"></span>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
