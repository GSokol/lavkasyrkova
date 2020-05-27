<div class="col-md-4 col-sm-6 col-xs-12 {{ !isset($place) ? 'add-block' : '' }} {{ $errors && ($errors->has('address') || $errors->has('latitude') || $errors->has('longitude')) ? 'visible' : '' }}" id="{{ 'place_'.(isset($office) ? $office->id : 'add') }}">
    <div class="panel panel-flat">
        <div class="panel-body">
            @include('_input_block', [
                'label' => 'Адрес',
                'name' => isset($place) ? 'address_'.$place->id : 'address',
                'type' => 'text',
                'placeholder' => 'Адрес',
                'value' => isset($place) ? $place->address : ''
            ])

            @include('_input_block', [
                'label' => 'Широта',
                'name' => isset($place) ? 'latitude_'.$place->id : 'latitude',
                'type' => 'text',
                'placeholder' => '00.000000',
                'value' => isset($place) ? $place->latitude : '',
            ])

            @include('_input_block', [
                'label' => 'Долгота',
                'name' => isset($place) ? 'longitude_'.$place->id : 'longitude',
                'type' => 'text',
                'placeholder' => '00.000000',
                'value' => isset($place) ? $place->longitude : '',
            ])

            @if (count($places) > 1)
                @include('admin._button_block', [
                    'type' => 'button',
                    'icon' => 'icon-trash',
                    'text' => 'Удалить '.$placeName,
                    'addClass' => 'delete-button pull-right',
                    'addAttr' => [
                        'del-data' => isset($place) ? $place->id : 'add',
                        'modal-data' => 'delete-modal'
                    ]
                ])
            @endif
        </div>
    </div>
</div>