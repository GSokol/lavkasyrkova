@extends('layouts.admin')

@section('content')
    @include('admin._orders_block',['orders' => $data['orders']])
@endsection