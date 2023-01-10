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
    <p>Здравствуйте {{ $order->user->name ? $order->user->name : $order->user->email }}!</p>
    <p>Меня зовут Эльвира, Лавка СырКова.</p>
    <p><i>Ваш заказ:</i></p>
    <p>@include('admin._order_content_block', ['order' => $order])</p>
    <br>
    <p class="warning">Когда сыр для вас будет нарезан и заказ собран, мы отправим вам уточнённый заказ и ссылку на оплату.</p>
    <p>Если у вас есть пожелания или вопросы по заказу, или вы хотите изменить заказ, пожалуйста напишите в ответ на это письмо или позвоните на номер <a href="tel:+79166178453">+79166178453</a></p>
    <p>Эльвира Астахова</p>
    <p><a href="mailto:Lavkasyrkova@gmail.com">Lavkasyrkova@gmail.com</a></p>
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
