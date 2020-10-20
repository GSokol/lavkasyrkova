<div class="col-md-{{ isset($col) ? $col : '3' }} col-sm-12 col-xs-12 {{ isset($addClass) ? $addClass : '' }}" {{ isset($delData) ? 'id=image_'.$delData : '' }}>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-title">{{ isset($label) ? $label : trans('admin_content.image') }}</div>
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

            <div class="form-group has-feedback {{ $errors && $errors->has($name) ? 'has-error' : '' }}">
                <div class="col-md-12">
                    <input {{ isset($inputId) ? 'id='.$inputId : '' }} type="file" name="{{ isset($name) && $name ? $name : 'image' }}" class="file-styled">
                    @if ($errors && $errors->has($name))
                        <span class="help-block error">{{ $errors->first($name) }}</span>
                    @endif
                </div>
            </div>

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
