@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="{{ mix('style/face/product.css') }}">
@endsection

@section('content')
    <div class="container" style="padding-bottom: 100px;">
        <h1>{{ $product->name }}</h1>
        <h6><a href="{{ route('face.category', ['slug' => $product->category->slug]) }}">{{ $product->category->name }}</a></h6>
        <div class="row">
            <div class="col-md-6 image">
                <img src="{{ asset($product->image) }}" title="{{ $product->name }}" onerror="this.src='/images/default.jpg'" />
            </div>
            <div class="col-md-6">
                <span class="price-block">{!! Helper::productCostSting($product) !!}</span>

                <div class="mb-20">{{ $product->additionally }}</div>

                @if ($product->active)
                    @include('_input_value_block', [
                        'name' => 'product_'.$product->id,
                        'min' => 0,
                        'max' => $product->parts ? Helper::getProductParts()[count(Helper::getProductParts())-1] : 100,
                        'class' => 'inline',
                        'unit' => Helper::productUnit($product),
                        'differentially' => $product->parts,
                        'price' => Helper::productPrice($product),
                        'increment' => $product->parts ? json_encode(Helper::getProductParts()) : 1,
                        'value' => Session::has('basket') ? Session::get('basket')[$product->id]['value'] : 0,
                    ])
                @else
                    <h5>Товара нет в наличии</h5>
                @endif

                @if ($product->aging)
                    <div class="mt-10">
                        <img class="iconograph" src="/images/icon-time.svg" alt="Выдержка">
                        <span class="param-title">Выдержка:</span> {{ $product->aging }}
                    </div>
                @endif

                @if ($product->rennet_type)
                    <div class="mt-10">
                        <img class="iconograph" src="/images/icon-cheese.svg" alt="Сычужный тип">
                        <span class="param-title">Сычужный тип:</span> {{ $product->rennet_type }}
                    </div>
                @endif

                @if ($product->gastro_combination)
                    <div class="mt-10">
                        <img class="iconograph" src="/images/icon-dish.svg" alt="Гастрономическое сочетание">
                        <span class="param-title">Гастрономическое сочетание:</span> {{ $product->gastro_combination }}
                    </div>
                @endif

                @if ($product->nutrients)
                    <div class="mt-10">
                        <img class="iconograph" src="/images/icon-drop.svg" alt="Питательные вещества">
                        <span class="param-title">Питательные вещества:</span> {{ $product->nutrients }}
                    </div>
                @endif

                @if ($product->alcohol_combination)
                    <div class="alcohol-combination-block">
                        <img class="iconograph" src="/images/icon-wine.svg" alt="Белое и красное сухое вино">
                        <span class="param-title">Белое красное сухое вино</span>
                        <div class="description">{{ $product->alcohol_combination }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-20">{{ $product->description }}</div>

        @if (count($product->related))
            <h3>Рекомендуем</h3>
            <div class="row">
                @foreach($product->related as $product)
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
            </div>
        @endif
    </div>

    @include('components.tasting')
    @include('components.info')
@endsection
