@extends('layouts.mail')

@section('content')
    <h1 class="section-title">{{ $title }} на сайте <a href="{{ Config::get('app.url') }}">{{ Config::get('app.name') }}</a></h1>
    <p><b>Заказ №</b> {{ $order->id }}</p>
    <p><b>Заказчик:</b> {{ $order->user->name ? $order->user->name : $order->user->email }}</p>
    <p><b>Контактный телефон:</b> {{ $order->user->phone ? $order->user->phone : 'не указан' }}<p>
    <p><b>Доставка </b>@include('admin._delivery_place_block',['order' => $order])</p>
    @if ($order->user->office_id > 2 && !$order->delivery && !$order->shop_id)
        <p><b>Получение заказа:</b> {{ date('d.m.Y',$order->tasting->time) }}</p>
    @endif
    <h2>Состав заказа:</h2>
    <p>@include('admin._order_content_block',['order' => $order])</p>
    <p><b>Стоимость заказа: </b>@include('admin._order_total_cost_block',['order' => $order])</p>
@endsection