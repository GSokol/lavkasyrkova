<?php $prodPrice = Helper::productPrice($product); $prodUnit = Helper::productUnit($product);?>

<div class="product product-{{ $product->id }} {{ isset($mainClass) ? $mainClass : 'col-md-3 col-sm-4 col-xs-12' }}">
    <div class="image">
        <a class="img-preview" href="{{ asset($product->image) }}"><img src="{{ asset($product->image) }}" /></a>
    </div>
    @include('_input_value_block',[
        'name' => 'product_'.$product->id,
        'min' => 0,
        'max' => $product->parts ? $data['product_parts'][count($data['product_parts'])-1] : 10,
        'unit' => Helper::productUnit($product),
        'differentially' => $product->parts,
        'price' => $prodPrice,
        'increment' => $product->parts ? json_encode($data['product_parts']) : 1,
        'value' => $value
    ])
    <h3>{{ $product->name }}</h3>
    <p class="description">{{ $product->description }}</p>
    <p class="price {{ $product->action ? 'action' : '' }}">{{ $prodPrice }}р. за {{ $product->parts ? $data['product_parts'][0].$prodUnit : '1'.$prodUnit }}</p>
    @if ($useCost)
        <div class="cost"><p>{{ Helper::productCost($product,$value) }}р.</p></div>
    @endif
</div>