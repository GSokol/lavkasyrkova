<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $data['seo']['title'] ? $data['seo']['title'] : 'Лавка Сыркова' }}</title>
@foreach($metas as $meta => $params)
    @if ($data['seo'][$meta])
        <meta {{ $params['name'] ? 'name='.$params['name'] : 'property='.$params['property'] }} content="{{ $data['seo'][$meta] }}">
    @endif
@endforeach

<link href="{{ mix('style/common.css') }}" rel="stylesheet" type="text/css">

<script type="text/javascript" src="{{ mix('js/face/app.js') }}"></script>
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script type="text/javascript" src="{{ asset('js/map.js') }}"></script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KKD3L3T');</script>
