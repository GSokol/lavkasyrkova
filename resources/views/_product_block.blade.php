<?php $prodPrice = Helper::productPrice($product); $prodUnit = Helper::productUnit($product);?>

<div class="product product-{{ $product->id }} {{ isset($mainClass) ? $mainClass : 'col-md-4 col-sm-4 col-xs-12' }}">
    <div class="image">
        @if (!$product->image)
            <img src="{{ asset('images/products/empty.jpg') }}" />
        @else
            <a class="img-preview" href="{{ $product->big_image ? asset($product->big_image) : asset($product->image) }}"><img src="{{ asset($product->image) }}" /></a>
        @endif
    </div>
    <div class="text-block">
        <h3>{{ $product->name }}</h3>
        @if ($product->addCategory && isset($product->addCategory->name))
            <p class="small">{{ $product->addCategory->name }}</p>
        @endif
        <p class="price {{ $product->action ? 'action' : '' }}"><span>{{ $prodPrice }}</span>р. за {!! $product->parts ? '<span>'.Helper::getProductParts()[0].'</span>'.$prodUnit : '<span>1</span>'.$prodUnit !!}</p>
        <p class="description">{{ $product->description }}</p>

    </div>
    <div class="value">
        @include('_input_value_block',[
            'name' => 'product_'.$product->id,
            'min' => 0,
            'max' => $product->parts ? Helper::getProductParts()[count(Helper::getProductParts())-1] : 10,
            'unit' => Helper::productUnit($product),
            'differentially' => $product->parts,
            'price' => $prodPrice,
            'increment' => $product->parts ? json_encode(Helper::getProductParts()) : 1,
            'value' => $value
        ])
        @if ($useCost)
            <p>{{ Helper::productCost($product,$value) }}р.</p>
        @endif
    </div>
</div>