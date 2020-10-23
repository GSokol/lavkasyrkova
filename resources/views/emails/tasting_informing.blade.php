@extends('face.layouts.mail')

@section('content')
    <h2 class="section-title">{{ $time }} состоится Доставка сыра в ваш офис по адресу {{ $address }}.</h2>
    <p>Вы можете сделать заказ на сайте и получить его в  офисе {{ $time }} СО СКИДКОЙ 10% от скюуммы вашего заказа.</p>
    <h1>Доставка бесплатно!</h1>
    <sup>Отказаться от рассылки можно в личном кабинете, пройдя по <a href="{{ Config::get('app.url').'/profile/user/?unsubscribe=1' }}">ссылке</a> или убрав галочку «Отправлять письма» в <a href="{{ Config::get('app.url').'/profile/user' }}">профиле</a> пользователя.</sup>
@endsection