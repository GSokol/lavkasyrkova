@extends('admin.layouts.default')

@section('content')
    @include('admin._modal_delete_block',['modalId' => 'delete-modal', 'function' => 'delete-tasting', 'head' => 'Вы действительно хотите удалить эту дегустацию?'])
    {{ csrf_field() }}

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Изображения на главной странице</h3>
            @include('admin._heading_elements_block')
        </div>
        <div class="panel-body">
            <form class="form-horizontal complex-form" enctype="multipart/form-data" action="{{ url('/admin/tasting-images') }}" method="post">
                {{ csrf_field() }}
                @for($i=1;$i<=3;$i++)
                    @include('admin._image_block',[
                        'col' => 4,
                        'preview' => asset('images/tastings/image'.$i.'.jpg'),
                        'name' => 'image'.$i
                    ])
                @endfor
                @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
            </form>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Дегустации</h3>
            @include('admin._heading_elements_block')
        </div>
        <div class="panel-body">
            @if (count($data['tastings']))
                <table class="table datatable-basic table-items">
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
                    @foreach ($data['tastings'] as $tasting)
                        <tr role="row" id="{{ 'tasting_'.$tasting->id }}">
                            <td class="id">{{ $tasting->id }}</td>
                            <td class="text-center"><a href="/admin/tastings?id={{ $tasting->id }}">{{ date('d.m.Y',$tasting->time) }}</a></td>
                            <td class="text-center">{{ $tasting->office->address }}</td>
                            <td class="text-center">{{ $tasting->created_at->format('d.m.Y') }}</td>
                            <td class="text-center">@include('admin._status_block',['status' => $tasting->informed > time(), 'trueLabel' => 'Да', 'falseLabel' => 'Нет'])</td>
                            <td class="text-center">@include('admin._status_block',['status' => $tasting->time > time(), 'trueLabel' => 'Новая', 'falseLabel' => 'прошедшая'])</td>
                            <td class="text-center">@include('admin._status_block',['status' => $tasting->active, 'trueLabel' => 'активна', 'falseLabel' => 'не активна'])</td>
                            <td class="delete"><span del-data="{{ $tasting->id }}" modal-data="delete-modal" class="glyphicon glyphicon-remove-circle"></span></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h1 class="text-center">Нет дегустаций</h1>
            @endif

            @include('admin._add_button_block',['href' => 'tastings/add', 'text' => 'Добавить дегустацию'])
        </div>
    </div>
@endsection