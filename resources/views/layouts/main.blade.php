<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Wed Mar 21 2018 11:43:04 GMT+0000 (UTC)  -->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $data['seo']['title'] ? $data['seo']['title'] : 'Лавка Сыркова' }}</title>
    @foreach($metas as $meta => $params)
        @if ($data['seo'][$meta])
            <meta {{ $params['name'] ? 'name='.$params['name'] : 'property='.$params['property'] }} content="{{ $data['seo'][$meta] }}">
        @endif
    @endforeach

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap-switch.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/top.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/main.css').Helper::randHash() }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/products.css').Helper::randHash() }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-switch.js') }}"></script>
{{--    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/switchery.min.js') }}"></script>--}}

    <script type="text/javascript" src="{{ asset('js/plugins/media/fancybox.min.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('js/plugins/pickers/daterangepicker.js') }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('js/pages/components_thumbnails.js') }}"></script>--}}

    <script type="text/javascript" src="{{ asset('js/core/main.controls.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/scrollreveal.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('js/feedback.js') }}"></script>--}}

    <script type="text/javascript" src="{{ asset('js/input-value.js').Helper::randHash() }}"></script>
    <script type="text/javascript" src="{{ asset('js/products.js').Helper::randHash() }}"></script>
    <script type="text/javascript" src="{{ asset('js/message.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
</head>
<body>

@include('layouts._product_modal_block')
@include('layouts._message_modal_block')

@if (!Auth::guest() && !Auth::user()->is_admin)
    @include('layouts._checkout_modal_block',['usingAjax' => true])
@endif

@include('layouts._nav_block')

{{ csrf_field() }}
@yield('content')
{{--<div id="on-top-button"><i class="glyphicon glyphicon-upload"></i></div>--}}
<div id="footer">
    <div class="container">
        <p>
            <span>Магазин Лавка Сыркова ©2019</span>
            <a href="" target="_blank"><i class="icon-instagram"></i></a>
            <a href="" target="_blank"><i class="icon-facebook2"></i></a>
        </p>
    </div>
</div>

</body>
</html>
