@foreach($order->orderToProducts as $item)
    {!! '<b>'.$item->product->name.'</b>'.' — '.($item->whole_value ? $item->whole_value.'шт.' : $item->part_value.Helper::getPartsName()).' <i>('.Helper::orderItemCost($item).'р.)</i><br>' !!}
@endforeach