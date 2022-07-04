@extends('dashboard::layouts.default')

@section('content')
    @include('admin._modal_delete_block', ['modalId' => 'delete-modal', 'function' => 'delete-tasting', 'head' => 'Вы действительно хотите удалить эту дегустацию?'])
    {{ csrf_field() }}

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Изображения на главной странице</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal complex-form" enctype="multipart/form-data" action="{{ url('/dashboard/tasting-images') }}" method="post">
                {{ csrf_field() }}
                @for($i=1; $i<=3; $i++)
                    @include('admin._image_block', [
                        'col' => 4,
                        'preview' => asset('images/tastings/image'.$i.'.jpg'),
                        'name' => 'image'.$i,
                    ])
                @endfor
                @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
            </form>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Дегустации</h3>
        </div>
        <div class="panel-body">
            <table class="table datatable-basic table-items" v-if="collection.length">
                <tr>
                    <th class="id">id</th>
                    <th class="text-center">Время проведения</th>
                    <th class="text-center">Место проведения</th>
                    <th class="text-center">Дата создания</th>
                    <th class="text-center">Прошла рассылка</th>
                    <th class="text-center">Новая/прошедшая</th>
                    <th class="text-center">Статус</th>
                    <th class="text-center">Удалить</th>
                </tr>
                <tr role="row" v-for="(row, index) in collection">
                    <td class="id" v-text="row.id"></td>
                    <td class="text-center"><a :href="route('dashboard.tasting', {id: row.id})" v-text="row.time_format"></a></td>
                    <td class="text-center" v-text="row.office.address"></td>
                    <td class="text-center" v-text="row.created_at"></td>
                    <td class="text-center"><span class="label" :class="[row.informed ? 'label-success' : 'label-info']" v-text="row.informed ? 'Да' : 'Нет'"></span></td>
                    <td class="text-center"><span class="label" :class="[row.in_time ? 'label-success' : 'label-info']" v-text="row.in_time ? 'Новая' : 'прошедшая'"></span></td>
                    <td class="text-center"><span class="label" :class="[row.active ? 'label-success' : 'label-info']" v-text="row.active ? 'активна' : 'не активна'"></span></td>
                    <td class="delete"><span class="glyphicon glyphicon-remove-circle" @click="removeTasting(row, index)"></span></td>
                </tr>
            </table>
            <h1 class="text-center" v-else>Нет дегустаций</h1>

            @include('admin._add_button_block', ['href' => 'tastings/add', 'text' => 'Добавить дегустацию'])
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="{{ mix('js/dashboard/tasting-list.js') }}"></script>
@endsection
