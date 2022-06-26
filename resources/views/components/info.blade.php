<div class="cover map" data-scroll-destination="shops">
    <div id="map"></div>
    <div>
        <h1 class="head">Магазины</h1>
        @foreach($stores as $store)
            <p>{!! $store['address'] !!}</p>
        @endforeach
        <p>Тел: {{ Settings::getAddress()->phone2.'; '.Settings::getAddress()->phone1 }}</p>
        <p><a href="mailto:{{ Settings::getAddress()->email }}">{{ Settings::getAddress()->email }}</a></p>
    </div>
</div>
