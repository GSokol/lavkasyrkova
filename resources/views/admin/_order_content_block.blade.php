@foreach($order->orderToProducts as $item)
    <a href="{{ route('face.product', ['slug' => $item->product->slug]) }}">{{ $item->product->name }}</a> — {{ $item->quantity_unit }} @if($item->actual_value) [реальный вес {{ $item->actual_value }} г.]  @endif<i>({{ $item->amount }} руб.)</i><br>
@endforeach
