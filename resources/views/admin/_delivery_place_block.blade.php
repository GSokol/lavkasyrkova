@if ($order->delivery)
    по адресу: {{ $order->user->address }}
@elseif ($order->shop_id)
    в магазин: {{ $order->shop->address }}
@else
    в офис: {{ $order->user->office->address }}
@endif