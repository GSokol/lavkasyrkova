@extends('layouts.main')

@section('content')
    <div id="main-image" data-scroll-destination="home">
        <div class="logo">
            <div><img class="logo" src="{{ asset('images/logo.png') }}" /></div>
        </div>
        <div class="text">
            <div>
                <img src="{{ asset('images/russian_cheese.png') }}" />
                <a href="#tasting" data-scroll="tastings"><img src="{{ asset('images/free_tastings.png') }}" /></a>
            </div>
        </div>
    </div>

    <div class="cover" data-scroll-destination="about">
        <div class="container">
            <h1 class="text-center">О компании</h1>
            <div class="col-md-6 col-sm-6 col-xs-12"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod enim eu odio dapibus, nec mollis tellus auctor. Maecenas eu efficitur nibh. Mauris eleifend feugiat ligula in elementum. Cras fringilla egestas urna vitae fermentum. Curabitur at ipsum ac enim fermentum porta id quis nulla. Vestibulum varius purus quam, ut rhoncus risus fermentum non. Praesent erat eros, ultricies ut lectus mattis, consectetur interdum mi. Nunc blandit, leo a congue ornare, libero dolor gravida dolor, sed euismod lacus augue vel arcu. Aliquam erat volutpat. Vivamus consectetur lectus dolor, vel feugiat quam ultricies at. Donec in mi ut elit dictum bibendum. Quisque tempor orci a purus tincidunt cursus. Phasellus varius lacinia ipsum ut tristique.</p></div>
            <div class="col-md-6 col-sm-6 col-xs-12"><p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas gravida metus egestas finibus lacinia. Etiam eget odio pulvinar, convallis quam eu, fermentum lorem. Cras sit amet tempus justo. Nulla tempus augue ut nunc dictum dignissim. Phasellus commodo ut neque ut sagittis. Vivamus imperdiet elit vitae urna pharetra rhoncus. Maecenas suscipit nisl imperdiet lobortis ullamcorper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec id velit odio. Pellentesque interdum tellus ornare enim mattis, vitae blandit tortor fringilla. Donec vulputate, nisl vel sollicitudin ullamcorper, nibh felis molestie elit, id porta orci nisi quis lectus. Morbi gravida ullamcorper elit non pharetra.</p></div>
        </div>
    </div>

    @if (count($data['actions']))
        <div class="cover pattern actions" data-scroll-destination="actions">
            <div class="container">
                <h1 class="text-center">Предложения недели</h1>

                <div class="owl-carousel">
                    @foreach($data['actions'] as $action)
                        <div class="action-product">
                            <?php $value = 0; ?>
                            @if (Session::has('basket'))
                                @foreach(Session::get('basket') as $id => $item)
                                    @if ($id == $action->id)
                                        <?php $value = $item['value']; ?>
                                        @break
                                    @endif
                                @endforeach
                            @endif

                            @include('_product_block', [
                                'mainClass' => 'action',
                                'product' => $action,
                                'value' => $value,
                                'useCost' => false
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="cover" data-scroll-destination="cheeses">
        <div class="container">
            <h1 class="text-center">Наши сыры</h1>
            <h3 class="text-center" id="cheeses-sub-head"></h3>
            <div id="categories">
                @include('_categories_block',['categories' => $data['categories'],'type' => 'category'])
                @include('_categories_block',['categories' => $data['add_categories'],'type' => 'add_category'])
            </div>
            <div id="products">
                <div class="order-form"></div>
                @include('_button_block',['type' => 'button', 'icon' => ' icon-backward', 'text' => 'Вернуться к списку категорий'])
            </div>
        </div>
    </div>

    <div class="cover pattern" data-scroll-destination="tastings">
        <div class="container">
            <h1 class="text-center">Дегустации</h1>
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

    <div id="map" class="cover-container cover" data-scroll-destination="contacts"></div>

    <script>window.map = [];</script>
    @foreach($data['shops'] as $office)
        <script>window.map.push({coords:[parseFloat("{{ $office->latitude }}"),parseFloat("{{ $office->longitude }}")],'address':"{{ $office->address }}"});</script>
    @endforeach
@endsection