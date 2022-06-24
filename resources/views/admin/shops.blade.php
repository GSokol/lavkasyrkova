@extends('admin.layouts.default')

@section('content')
    @include('admin._modal_delete_block', ['modalId' => 'delete-modal', 'function' => 'delete-shop', 'head' => 'Вы действительно хотите удалить этот магазин?'])

    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="panel-heading">
                <h4 class="panel-title">Магазины</h4>
            </div>
            @include('admin._places_form_block',[
                'places' => $data['shops'],
                'url' => 'shops',
                'placeName' => 'магазин'
            ])
        </div>
    </div>
@endsection
