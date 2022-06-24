@extends('face.layouts.mail')

@section('content')
    <h1 class="section-title">{{ $title }} на сайте <a href="{{ Config::get('app.url') }}">{{ Config::get('app.name') }}</a></h1>
    <p><b>Заказ №</b> {{ $order->id }}</p>
    <p><strong>Статус:</strong> {{ $order->status->name }}</p>
    <p><b>Заказчик:</b> {{ $order->user->name ? $order->user->name : $order->user->email }}</p>
    <p><b>Контактный телефон:</b> {{ $order->user->phone ? $order->user->phone : 'не указан' }}<p>
    <p><b>Доставка </b>{{ $order->delivery_info }}</p>
    @if ($order->user->office_id > 2 && !$order->delivery && !$order->shop_id)
        <p><b>Получение заказа:</b> {{ date('d.m.Y',$order->tasting->time) }}</p>
    @endif
    <p><b>Примечание:</b> {{ $order->description }}</p>
    <h2>Состав заказа:</h2>
    <p>@include('admin._order_content_block', ['order' => $order])</p>
    <hr>
    <p><strong>Стоимость заказа: </strong>{{ $order->total_amount }} руб.</p>
    @if ($order->discount_value)
        <p><strong>Скидка: </strong>{{ $order->discount_value }}% ({{ $order->discount_amount }} руб.)</p>
        <p><strong>Итого к оплате: </strong>{{ $order->checkout_amount }} руб.</p>
    @endif
@endsection
