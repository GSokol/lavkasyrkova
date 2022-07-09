@extends('layouts.mail')

@section('header')
    <tr>
        <td class="header">
            <a href="#" style="display: inline-block;">
                <img src="{{ asset('/images/logo_small.svg') }}" class="logo" alt="Лавка Сыркова">
            </a>
        </td>
    </tr>
@endsection

@section('content')
    <h1 class="section-title">Заказ № {{ $order->id }}</h1>
    <p><strong>Дата заказа:</strong> {{ $order->created_at }}</p>
    <p><strong>Статус:</strong> {{ $order->status->name }}</p>
    <p><strong>Заказчик:</strong> {{ $order->user->name ? $order->user->name : $order->user->email }}</p>
    <p><strong>Контактный телефон:</strong> {{ $order->user->phone ? $order->user->phone : 'не указан' }}<p>
    <p><strong>Доставка </strong>{{ $order->delivery_info }}</p>
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

@section('footer')
    <tr>
        <td>
            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="content-cell" align="center">
                        Лавка Сыркова © 2019
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
