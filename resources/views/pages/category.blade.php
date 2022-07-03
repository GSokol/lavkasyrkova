@extends('layouts.main')

@section('content')
    <div class="cover first" data-scroll-destination="cheeses">
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

    <div class="cover">
        <div class="container">
            <div style="padding-top: 20px;">
                @foreach ($categories as $category)
                    @if (count($category->products))
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <a href="{{ route('face.category', ['slug' => $category->slug]) }}">
                                <h6>{{ $category->name }}</h6>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    
    @include('components.tasting')
    @include('components.info')
@endsection
