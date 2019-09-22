@if ($order->delivery)
    <b>Не позже: </b>{{ $order->created_at->addDays(7)->format('d.m.Y') }}
@elseif ($order->shop_id)
    <b>Не позже: </b>{{ $order->created_at->addDays(2)->format('d.m.Y') }}
@else
    {{ date('d.m.Y',$order->user->office->tastings[0]->time) }}
@endif