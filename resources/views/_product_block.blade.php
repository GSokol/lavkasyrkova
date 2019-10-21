<?php $prodPrice = Helper::productPrice($product); $prodUnit = Helper::productUnit($product);?>

<div class="product product-{{ $product->id }} {{ isset($mainClass) ? $mainClass : 'col-md-4 col-sm-4 col-xs-12' }}">
    <div class="image">
        @if (!$product->image)
            <img src="{{ asset('images/products/empty.jpg') }}" />
        @else
            <a class="img-preview" href="{{ $product->big_image ? asset($product->big_image) : asset($product->image) }}"><img src="{{ asset($product->image) }}" /></a>
        @endif
    </div>
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
    <div class="text-block">
        <h3>{{ $product->name }}</h3>
        <p class="small">{{ $product->addCategory->name }}</p>
        <p class="description">{{ $product->description }}</p>
        <p class="price {{ $product->action ? 'action' : '' }}">{{ $prodPrice }}р. за {{ $product->parts ? Helper::getProductParts()[0].$prodUnit : '1'.$prodUnit }}</p>
    </div>
    @if ($useCost)
        <div class="cost"><p>{{ Helper::productCost($product,$value) }}р.</p></div>
    @endif
</div>