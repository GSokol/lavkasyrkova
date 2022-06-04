@extends('dashboard::layouts.default')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="panel-body">
                    @include('_input_block', [
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'placeholder' => 'Title',
                        'value' => $settings['seo']['title']
                    ])
                </div>
                <div class="panel-heading">
                    <h4 class="panel-title">Мета-теги</h4>
                </div>
                <div class="panel-body">
                    @foreach($settings['seo'] as $name => $value)
                        @if (in_array($name, ['meta_description', 'meta_keywords', 'meta_og_description']))
                            @include('admin._textarea_block', [
                                'label' => $name,
                                'name' => $name,
                                'value' => $value,
                                'simple' => true
                            ])
                        @else
                            @include('_input_block', [
                                'label' => $name,
                                'name' => $name,
                                'type' => 'text',
                                'placeholder' => $name,
                                'value' => $value,
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
