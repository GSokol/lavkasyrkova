<div class="product product-{{ $product->id }} {{ isset($mainClass) ? $mainClass : 'col-md-4 col-sm-4 col-xs-12' }}">
    <div class="image">
        @if (!$product->active)
            @if ($product->image)
                @include('_product_preview_block',['image' => 'images/not-available.png', 'imageClass' => 'not-available'])
            @else
                <img class="not-available" src="{{ asset('images/not-available.png') }}" />
            @endif
        @endif

        @if (!$product->image)
            <img src="{{ asset('images/products/empty.jpg') }}" />
        @elseif ($product->image && $product->active)
            @include('_product_preview_block', ['image' => $product->image])
        @else
            <img src="{{ asset($product->image) }}" />
        @endif
    </div>
    <div class="text-block" {{ isset($textBlockHeight) && $textBlockHeight ? 'style=height:'.$textBlockHeight.'px' : '' }}>
        <h3>{{ $product->name }}</h3>
        @if ($product->additionally)
            <h4>{{ $product->additionally }}</h4>
        @endif
        @if ($product->addCategory && isset($product->addCategory->name))
            <p class="small">{{ str_replace('Сыры', 'Сыр', $product->addCategory->name) }}</p>
        @endif
        <p class="description">{{ $product->description }}</p>
        <p class="price {{ $product->action ? 'action' : '' }}">{!! Helper::productCostSting($product) !!}</p>
    </div>
    <div class="value">
        @if ($product->active)
            @include('_input_value_block',[
                'name' => 'product_'.$product->id,
                'min' => 0,
                'max' => $product->parts ? Helper::getProductParts()[count(Helper::getProductParts())-1] : 100,
                'unit' => Helper::productUnit($product),
                'differentially' => $product->parts,
                'price' => Helper::productPrice($product),
                'increment' => $product->parts ? json_encode(Helper::getProductParts()) : 1,
                'value' => $value,
            ])
        @else
            <div class="disabled-value-container">{{ $value .' '.Helper::productUnit($product) }}</div>
        @endif

        @if ($useCost)
            <p class="cost">{{ Helper::productCost($product, $value) }} руб</p>
        @endif
    </div>
</div>
