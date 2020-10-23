<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $data['seo']['title'] ? $data['seo']['title'] : 'Лавка Сыркова' }}</title>
@foreach($metas as $meta => $params)
    @if ($data['seo'][$meta])
        <meta {{ $params['name'] ? 'name='.$params['name'] : 'property='.$params['property'] }} content="{{ $data['seo'][$meta] }}">
    @endif
@endforeach

<!-- <link href=" asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
<link href=" asset('css/bootstrap-switch.css') }}" rel="stylesheet">
<link href=" asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">
<link href=" asset('css/core.css') }}" rel="stylesheet" type="text/css">
<link href=" asset('css/components.css') }}" rel="stylesheet" type="text/css">

<link href=" asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
<link href=" asset('css/top.css') }}" rel="stylesheet" type="text/css">
<link href=" asset('css/main.css') }}" rel="stylesheet" type="text/css">
<link href="{ asset('css/products.css') }}" rel="stylesheet" type="text/css">
<link href="{ asset('css/loader.css') }}" rel="stylesheet" type="text/css">
<link href="{ asset('css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
<link href="{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css"> -->

<link href="{{ mix('style/common.css') }}" rel="stylesheet" type="text/css">

<script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-switch.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/media/fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/main.controls.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scrollreveal.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/input-value.js').Helper::randHash() }}"></script>
<script type="text/javascript" src="{{ asset('js/products.js').Helper::randHash() }}"></script>
<script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js?').Helper::randHash() }}"></script>

<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script type="text/javascript" src="{{ asset('js/map.js') }}"></script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KKD3L3T');</script>
