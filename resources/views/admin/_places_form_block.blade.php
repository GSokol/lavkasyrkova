<form class="form-horizontal complex-form" enctype="multipart/form-data" action="{{ url('/dashboard/'.$url) }}" method="post">
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

@section('script')
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
@endsection
