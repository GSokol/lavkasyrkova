@foreach($order->orderToProducts as $item)
    <strong>{{ $item->product->name }}</strong> — {{ $item->quantity_unit }} @if($item->actual_value) [реальный вес {{ $item->actual_value }} г.]  @endif<i>({{ $item->amount }} руб.)</i><br>
@endforeach
