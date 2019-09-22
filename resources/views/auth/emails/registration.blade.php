@extends('layouts.mail')

@section('content')
    <h1 class="section-title">{{ trans('auth.confirm_register_head') }}</h1>
    <p>{{ trans('auth.confirm_register_part1') }}</p>
    <p>{{ trans('auth.confirm_register_part2') }} <a href="{{ url('/confirm-registration/'.$token) }}">{{ url('/confirm-registration/'.$token) }}</a><p>
@endsection