<div class="cover map" data-scroll-destination="shops">
    <div id="map"></div>
    <div>
        <h1 class="head">Магазины</h1>
        @foreach($stores as $store)
            <p>{!! $store['address'] !!}</p>
        @endforeach
        <p>ИП Ковальчук Александра Александровна</p>
        <p>ИНН 774317338424</p>
        <p>Тел: {{ Settings::getAddress()->phone1.'; '.Settings::getAddress()->phone2 }}</p>
        <p><a href="mailto:{{ Settings::getAddress()->email }}">{{ Settings::getAddress()->email }}</a></p>
    </div>
</div>
