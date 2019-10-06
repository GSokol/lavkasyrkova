@extends('layouts.main')

@section('content')
    <div id="main-image" data-scroll-destination="home">
        <div class="logo">
            <div><img class="logo" src="{{ asset('images/logo.svg') }}" /></div>
        </div>
        <div class="text">
            <div>
                <p>РОССИЙСКИЙ ФЕРМЕРСКИЙ СЫР<br>от рикотты до пармезана</p>
                <a href="#tasting" data-scroll="tastings">@include('_button_block',[
                    'addClass' => 'big-button',
                    'type' => 'button',
                    'icon' => null,
                     'text' => 'Бесплатные тематические дегустации'
                 ])</a>
            </div>
        </div>
    </div>

    @if (count($data['actions']))
        <div class="cover owl-carousel actions" data-scroll-destination="actions">
            @foreach($data['actions'] as $action)
                <div id="action-{{ $action->id }}" class="action" style="background: url('{{ $action->big_image ? asset($action->big_image) : asset('images/auth_bg.jpg') }}') center; background-size: cover;">
                    <div class="container">
                        <div class="col-md-4 col-sm-6 col-xs-12 action-product">
                            <h1>Предложение недели</h1>
                            <h2>{{ $action->name }}</h2>
                            <p class="description">{{ $action->description }}</p>
                            <p class="action-price">{{ Helper::productPrice($action).'р. за '.Helper::productMinVal($action) }}</p>
                            @include('_button_block',['type' => 'button', 'icon' => 'icon-cart5', 'text' => 'Купить', 'addAttr' => ['data-id' => $action->id]])
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="cover" data-scroll-destination="cheeses">
        <div class="container">
            <h1 class="head" id="cheeses-head">Наши сыры</h1>
            <h1 class="head" id="cheeses-sub-head"></h1>
            <div id="categories">
                @include('_categories_block',['categories' => $data['categories'],'type' => 'category'])
{{--                @include('_categories_block',['categories' => $data['add_categories'],'type' => 'add_category'])--}}
            </div>
            <div id="products">
                @include('_button_block',['type' => 'button', 'icon' => ' icon-backward', 'text' => 'Вернуться к списку категорий', 'addAttr' => ['style' => 'margin-bottom:40px;']])
                <div class="order-form"></div>
                @include('_button_block',['type' => 'button', 'icon' => ' icon-backward', 'text' => 'Вернуться к списку категорий'])
            </div>
        </div>
    </div>

    <div class="cover pattern" data-scroll-destination="tastings">
        <div class="container">
            <h1 class="head">Дегустации</h1>
            @foreach(['Как проходила дегустация сыра в БЦ Метрополис','Угощаем сыром в Музеоне!','Дегустация сыра.<br>Вкусный сыр у вас в офисе.<br>Нравится? Тогда мы идём к вам!'] as $k => $item)
                @include('_framed_image_block',[
                    'addClass' => 'tastings col-md-4 col-sm-2 col-xs-12',
                    'preview' => asset('images/tastings/image'.($k+1).'.jpg'),
                    'description' => $item
                ])
            @endforeach

            @include('_tasting_block',['icon' => 'icon_place.png','head' => 'Место проведения','text' => 'Столовые или специальные места для мероприятий в офисных центрах Москвы и Подмосковья'])
            @include('_tasting_block',['icon' => 'icon_what_will.png','head' => 'Что будет','text' => 'Дегустация 9 - 10 видов вкусного сыра. Мы расскажем о каждом виде, сочетаниях с винами и продуктами, сезонных рецептах и интересных способах подачи сыра.'])
            @include('_tasting_block',['icon' => 'icon_clock.png','head' => 'Время проведения','text' => 'Будние дни с 12 до 16 часов'])
            @include('_tasting_block',['icon' => 'icon_mail.png','head' => 'Уже хотите?','text' => 'Напишите нам на почту: <a href="mailto:lavkasyrkov@gmail.com">lavkasyrkov@gmail.com</a>.<br>Согласуем время и место и ждите в гости!'])

            @if ($data['tasting_new'])
                <div class="new-tasting {{ count($data['tastings']) }} col-md-12 col-sm-12 col-xs-12">
                    <h4>{{ $data['tasting_new']->name }} состоится {{ date('d.m.Y',$data['tasting_new']->time) }}</h4>
                    <p>По адресу: {{ $data['tasting_new']->place }}</p>
                    @if (isset($data['tasting_new']) && $data['tasting_new'] && (!isset($data['tasting_signed']) || !$data['tasting_signed']))
                        @if (Auth::guest())
                            <a href="/login">@include('_get_tasting_button_block')</a>
                        @else
                            <a id="get-tasting" href="#">@include('_get_tasting_button_block')</a>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="cover map" data-scroll-destination="shops">
        <div id="map"></div>
        <div>
            <h1 class="head">Магазины</h1>
            <script>window.map = [];</script>
            @foreach($data['shops'] as $shop)
                <p>{!! $shop->address !!}</p>
                <script>window.map.push({coords:[parseFloat("{{ $shop->latitude }}"),parseFloat("{{ $shop->longitude }}")],'address':"{{ strip_tags($shop->address) }}"});</script>
            @endforeach
            <p>Тел: {{ Settings::getAddress()->phone1.'; '.Settings::getAddress()->phone2 }}</p>
            <p><a href="mailto:{{ Settings::getAddress()->email }}">{{ Settings::getAddress()->email }}</a></p>
        </div>
    </div>

@endsection