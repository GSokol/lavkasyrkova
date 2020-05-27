@extends('layouts.mail')

@section('content')
    <h1 class="section-title">Участие в дегустации «{{ $tasting->name }}», которая состоится в {{ $tasting->place.' '.date('d.m.Y',$tasting->time) }}</h1>
    <h3>Пользователь:</h3>
    <p><b>Имя:</b> {{ $tasting->tastingToUsers->user->name ? $tasting->tastingToUsers->user->name : 'не указано' }}</p>
    <p><b>Контактный телефон:</b> {{ $tasting->tastingToUsers->user->phone ? $tasting->tastingToUsers->user->phone : 'не указан' }}</p>
    <p><b>E-mail:</b> {{ $tasting->tastingToUsers->user->email }}<p>
@endsection