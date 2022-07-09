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
    <p>Здравствуйте {{ $order->user->name ? $order->user->name : $order->user->email }}, мы получили ваш заказ:</p>
    <p>@include('admin._order_content_block', ['order' => $order])</p>
    <p class="warning">Когда сыр для вас будет отрезан и заказ будет сформирован, мы отправим вам уточнённый заказ и ссылку на оплату.</p>
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
