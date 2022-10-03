@extends('layouts.main')

@section('content')
    <div id="main-image" data-scroll-destination="home">
        <div class="logo">
            <div><img class="logo" src="{{ asset('images/logo.svg') }}" /></div>
        </div>
        <div class="text">
            <div>
                <p>РОССИЙСКИЙ ФЕРМЕРСКИЙ СЫР<br>от рикотты до пармезана</p>
            </div>
        </div>
        <div class="button">
            <a href="/category/podarochnye-korziny">
                @include('_button_block', [
                    'addClass' => 'big-button',
                    'type' => 'button',
                    'icon' => null,
                    'text' => 'Дарите вкусные подарки',
                ])
            </a>
        </div>
    </div>

    @if (count($actions))
        <div class="cover owl-carousel actions" data-scroll-destination="actions" id="actions">
            @foreach($actions as $action)
                <div id="action-{{ $action->id }}" class="action" style="background: url('{{ $action->big_image ? asset($action->big_image) : asset('images/auth_bg.jpg') }}') center; background-size: cover;">
                    <div class="container">
                        <div class="col-md-4 col-sm-6 col-xs-12 action-product">
                            <h1>{{ $action->new ? 'Новинка!' : 'Предложение недели' }}</h1>
                            <h2>{{ $action->name }}</h2>
                            <p class="description">{{ $action->description }}</p>
                            @if ($action->new)
                                <p class="action-price">{!! Helper::productCostSting($action) !!}</p>
                            @else
                                <p class="action-price"><span class="old">{{ Helper::productPrice($action,true) }} руб</span> {!! Helper::productCostSting($action) !!}</p>
                            @endif
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
                @foreach ($categories as $category)
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
        </div>
    </div>

    <!-- @ include('components.tasting') -->

    @include('components.info')
@endsection
