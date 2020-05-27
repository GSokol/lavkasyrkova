@if ($order->delivery)
    по адресу: {{ $order->user->address }}
@elseif ($order->shop_id)
    в магазин: {{ $order->shop->address }}
@else
    {{ $order->user->office->id > 2 ? 'в офис: '.$order->user->office->address : $order->user->office->address }}
@endif