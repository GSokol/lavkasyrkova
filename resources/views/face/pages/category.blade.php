@extends('face.layouts.main')

@section('content')
    <div class="cover" data-scroll-destination="cheeses">
        <div class="container">
            <h1 class="head" id="cheeses-head">{{ $category->name }}</h1>
            <div>
                <div class="order-form"></div>
                <div id="on-top-button"><i class="glyphicon glyphicon-upload"></i></div>

                @if (count($products))
                    @foreach($products as $product)
                        <?php $value = 0; ?>

                        @if (isset($data['order']))
                            @foreach($data['order']->orderToProducts as $item)
                                @if ($item->product->id == $product->id)
                                    @if ($item->whole_value)
                                        <?php $value = $item->whole_value; ?>
                                    @elseif ($item->part_value)
                                        <?php $value = $item->part_value; ?>
                                    @endif
                                    @break
                                @endif
                            @endforeach
                        @elseif (Session::has('basket'))
                            @foreach(Session::get('basket') as $id => $item)
                                @if ($id == $product->id)
                                    <?php $value = $item['value']; ?>
                                    @break
                                @endif
                            @endforeach
                        @endif

                        @include('_product_block', [
                            'product' => $product,
                            'value' => $value,
                            'useCost' => true,
                        ])
                    @endforeach
                @else
                    <h4 class="text-center">Скоро здесь появятся новые товары</h4>
                @endif
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
