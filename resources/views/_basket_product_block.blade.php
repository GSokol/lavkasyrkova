<p class="product-name">{{ $product->name }}</p>
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