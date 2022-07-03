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
    @include('components.tasting')
    @include('components.info')
@endsection
