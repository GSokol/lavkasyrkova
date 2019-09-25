<div class="basket-product product-{{ $product->id }}">
    <div class="product-name">{{ $product->name }}</div>
    <div>
        @include('_input_value_block',[
            'name' => 'product_'.$product->id,
            'min' => 0,
            'max' => $product->parts ? $productParts[count($productParts)-1] : 10,
            'unit' => $product->parts ? 'гр.' : 'шт.',
            'differentially' => $product->parts,
            'price' => $price,
            'increment' => $product->parts ? json_encode($productParts) : 1,
            'value' => $value
        ])
    </div>
    <div class="product-cost">{{ Helper::productCost($product,$value) }}р.</div>
    <div class="product-delete"><i class="icon-close2"></i></div>
</div>

