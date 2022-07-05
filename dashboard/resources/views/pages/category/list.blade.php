@extends('dashboard::layouts.default')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title">Категории</h3>
                </div>
                <div class="col-md-4 text-right">
                    <a class="btn bg-success-600" href="{{ route('dashboard.category', ['id' => 'new']) }}"><i class="icon-add"></i> Добавить категорию</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-items">
                <thead>
                    <tr>
                        <th class="id">id</th>
                        <th class="text-center">Изображение</th>
                        <th class="">Название</th>
                        <th class="">Ссылка</th>
                        <th class="">Дата редактирования</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" v-for="(row, index) in collection">
                        <td class="id" v-text="row.id"></td>
                        <td class="text-center image"><a v-if="row.image" class="img-preview" :href="'/' + row.image"><img :src="'/' + row.image" onerror="this.src='/images/default.jpg'" loading="lazy" /></a></td>
                        <td class=""><a :href="'/dashboard/category/' + row.id" v-text="row.name"></a></td>
                        <td class=""><span v-text="row.slug"></span></td>
                        <td class=""><span v-text="row.updated_at"></span></td>
                        <td class="delete">
                            <span class="glyphicon glyphicon-remove-circle" @click="onDelete(row, index)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/dashboard/category.js') }}"></script>
@endsection
