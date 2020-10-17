@extends('admin.layouts.default')

@section('content')
    @include('admin._modal_delete_block',['modalId' => 'delete-modal', 'function' => 'delete-office', 'head' => 'Вы действительно хотите удалить этот офис?'])

    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="panel-heading">
                <h4 class="panel-title">Офисы</h4>
            </div>
            @include('admin._places_form_block',[
                'places' => $data['offices'],
                'url' => 'offices',
                'placeName' => 'офис'
            ])
        </div>
    </div>
@endsection