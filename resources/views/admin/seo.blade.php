@extends('layouts.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ url('/admin/seo') }}" method="post">
                {{ csrf_field() }}
                <div class="panel-body">
                    @include('_input_block', [
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'placeholder' => 'Title',
                        'value' => $data['seo']['title']
                    ])
                </div>
                <div class="panel-heading">
                    <h4 class="panel-title">Мета-теги</h4>
                </div>
                <div class="panel-body">
                    @foreach($data['metas'] as $meta => $params)
                        @if ($params['name'] == 'description' || $params['name'] == 'keywords' || $params['property'] == 'og:description')
                            @include('admin._textarea_block', [
                                'label' => $params['name'] ? 'name="'.$params['name'].'"' : 'property="'.$params['property'].'"',
                                'name' => $meta,
                                'value' => $data['seo'][$meta],
                                'simple' => true
                            ])
                        @else
                            @include('_input_block', [
                                'label' => $params['name'] ? 'name="'.$params['name'].'"' : 'property="'.$params['property'].'"',
                                'name' => $meta,
                                'type' => 'text',
                                'placeholder' => $params['name'] ? 'name="'.$params['name'].'"' : 'property="'.$params['property'].'"',
                                'value' => $data['seo'][$meta]
                            ])
                        @endif
                    @endforeach
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
                </div>
            </form>
        </div>
    </div>
@endsection