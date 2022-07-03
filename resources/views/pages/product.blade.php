@extends('layouts.main')

@section('content')
    <div class="container" style="padding-bottom: 100px;">
        <h1>{{ $product->name }}</h1>
        <h6>{{ $product->category->name }}</h6>
        <div class="col-md-5 image">
            <img src="{{ asset($product->image) }}" title="{{ $product->name }}" />
        </div>
        <div class="col-md-7">
            <div class="">{{ $product->description }}</div>
        </div>
    </div>
    
    @include('components.tasting')
    @include('components.info')
@endsection
