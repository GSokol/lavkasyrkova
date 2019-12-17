@extends('layouts.mail')

@section('content')
    <h2 class="section-title">Ближайшая дегустация по адресу {{ $address }} состоится {{ $time }}.</h2>
    <sup>Отказаться от рассылки можно в личном кабинете, пройдя по <a href="{{ Config::get('app.url').'/profile/user/?unsubscribe=1' }}">ссылке</a> или убрав галочку «Отправлять письма» в <a href="{{ Config::get('app.url').'/profile/user' }}">профиле</a> пользователя.</sup>
@endsection