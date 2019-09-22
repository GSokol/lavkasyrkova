<div class="col-md-{{ isset($col) ? $col : '3' }} col-sm-12 col-xs-12 {{ isset($addClass) ? $addClass : '' }}" {{ isset($delData) ? 'id=image_'.$delData : '' }}>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-title">{{ trans('admin_content.image') }}</div>
        </div>
        <div class="panel-body edit-image-preview">
            @if (isset($preview) && $preview)
                @if (isset($full) && $full)
                    <a class="img-preview" href="{{ asset($full) }}">
                @endif
                    <img src="{{ asset($preview) }}?{{ md5(rand(1,100000)*time()) }}" />
                @if (isset($full) && $full)
                    </a>
                @endif
            @else
                <img src="/images/placeholder.jpg" />
            @endif
            @include('admin._input_file_block', ['label' => '', 'name' =>  isset($name) && $name ? $name : 'image'])

            @if (isset($delData))
                @include('admin._button_block', [
                    'type' => 'button',
                    'icon' => 'icon-trash',
                    'text' => 'Удалить фото',
                    'addClass' => 'delete-button pull-right',
                    'addAttr' => [
                        'del-data' => $delData,
                        'modal-data' => 'delete-modal'
                    ]
                ])
            @endif
        </div>
    </div>
</div>