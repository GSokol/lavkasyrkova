@extends('face.layouts.mail')

@section('content')
    <h2 class="section-title">Изменены статусы следующих дегустаций:</h2>
    <ul>
        @foreach($tastings as $id)
            <li>id: {{ $id }}</li>
        @endforeach
    </ul>

    <h2 class="section-title">Изменены статусы следующих заказов:</h2>
    <ul>
        @foreach($orders as $id)
            <li>id: {{ $id }}</li>
        @endforeach
    </ul>
@endsection