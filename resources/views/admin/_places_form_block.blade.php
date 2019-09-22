<form class="form-horizontal complex-form" enctype="multipart/form-data" action="{{ url('/admin/'.$url) }}" method="post">
    {{ csrf_field() }}
    <div class="panel-body">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="map" id="map"></div>
            </div>
        </div>
        <script>window.map = [];</script>
        @foreach($places as $place)
            @include('admin._place_block',['place' => $place])
            <script>window.map.push({coords:[parseFloat("{{ $place->latitude }}"),parseFloat("{{ $place->longitude }}")],'address':"{{ $place->address }}"});</script>
        @endforeach
        @include('admin._place_block',['place' => null])
    </div>
    @include('admin._button_block', ['type' => 'button', 'icon' => 'icon-database-add', 'text' => 'Добавить '.$placeName, 'addClass' => 'add-button pull-left'])
    @include('admin._button_block', ['type' => 'submit', 'icon' => ' icon-floppy-disk', 'text' => trans('admin_content.save'), 'addClass' => 'pull-right'])
</form>