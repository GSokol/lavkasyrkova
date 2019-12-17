@extends('layouts.mail')

@section('content')
    <h2 class="section-title">Ближайшая дегустация по адресу {{ $address }} состоится {{ $time }}.</h2>
@endsection