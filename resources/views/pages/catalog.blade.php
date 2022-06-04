@extends('layouts.main')

@section('content')
    <div class="cover first" data-scroll-destination="cheeses">
        <div class="container">
            <h1 class="head" id="cheeses-head">Наши сыры</h1>
            <h1 class="head" id="cheeses-sub-head"></h1>
            <div id="categories">
                @foreach($categories as $category)
                    @if (count($category->products))
                        <div class="category col-md-3 col-sm-4 col-xs-12">
                            <a href="{{ route('face.category', ['slug' => $category->slug]) }}" class="image">
                                <img src="{{ $category->image ? asset($category->image) : asset('images/products/empty.jpg') }}" />
                            </a>
                            <h3>{{ $category->name }}</h3>
                        </div>
                    @endif
                @endforeach
            </div>
            <div id="products">
                <div class="order-form"></div>
                <div id="on-top-button"><i class="glyphicon glyphicon-upload"></i></div>
            </div>
        </div>
    </div>

    <div class="cover pattern" data-scroll-destination="tastings">
        <div class="container">
            <h1 class="head">Дегустации</h1>
            @foreach(['Как проходила дегустация сыра в БЦ Метрополис', 'Угощаем сыром в Музеоне!', 'Дегустация сыра.<br>Вкусный сыр у вас в офисе.<br>Нравится? Тогда мы идём к вам!'] as $k => $item)
                @include('_framed_image_block',[
                    'addClass' => 'tastings col-md-4 col-sm-2 col-xs-12',
                    'preview' => asset('images/tastings/image'.($k+1).'.jpg'),
                    'description' => $item
                ])
            @endforeach

            @include('_tasting_block',['icon' => 'icon_star.svg','head' => 'Место проведения','text' => 'Столовые или специальные места для мероприятий в офисных центрах Москвы и Подмосковья'])
            @include('_tasting_block',['icon' => 'icon_gift.svg','head' => 'Что будет','text' => 'Дегустация 9 - 10 видов вкусного сыра. Мы расскажем о каждом виде, сочетаниях с винами и продуктами, сезонных рецептах и интересных способах подачи сыра.'])
            @include('_tasting_block',['icon' => 'icon_clock.svg','head' => 'Время проведения','text' => 'Будние дни с 12 до 16 часов'])
            @include('_tasting_block',['icon' => 'icon_clouds.svg','head' => 'Уже хотите?','text' => 'Напишите нам на почту: <a href="mailto:lavkasyrkov@gmail.com">lavkasyrkov@gmail.com</a>.<br>Согласуем время и место и ждите в гости!'])
        </div>
    </div>

    <div class="cover map" data-scroll-destination="shops">
        <div id="map"></div>
        <div>
            <h1 class="head">Магазины</h1>
            <script>window.map = [];</script>
            @foreach($stores as $store)
                <p>{!! $store->address !!}</p>
                <script>window.map.push({coords:[parseFloat("{{ $store->latitude }}"), parseFloat("{{ $store->longitude }}")],'address':"{{ strip_tags($store->address) }}"});</script>
            @endforeach
            <p>Тел: {{ Settings::getAddress()->phone1.'; '.Settings::getAddress()->phone2 }}</p>
            <p><a href="mailto:{{ Settings::getAddress()->email }}">{{ Settings::getAddress()->email }}</a></p>
        </div>
    </div>
@endsection
