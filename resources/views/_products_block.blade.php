@foreach($data['products'] as $product)
    <?php $value = 0; $valueType = $product->parts; ?>

    @if (isset($data['order']))
        @foreach($data['order']->orderToProducts as $item)
            @if ($item->product->id == $product->id)
                @if ($item->whole_value)
                    <?php $value = $item->whole_value; $valueType = 0; ?>
                @elseif ($item->part_value)
                    <?php $value = $item->part_value; $valueType = 1; ?>
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
