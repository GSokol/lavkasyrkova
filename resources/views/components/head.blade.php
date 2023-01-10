<title>{{ $settings['seo']['title'] ?: 'Лавка Сыркова' }}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{ $settings['seo']['meta_description'] }}">
<meta name="keywords" content="{{ $settings['seo']['meta_keywords'] }}">
<meta property="og:title" content="{{ $settings['seo']['meta_og_title'] }}">
<meta property="og:description" content="{{ $settings['seo']['meta_og_description'] }}">
<meta property="og:image" content="{{ $settings['seo']['meta_og_image'] }}">

<link href="{{ mix('style/face/common.css') }}" rel="stylesheet" type="text/css">
@yield('style')

<script type="text/javascript" src="{{ mix('js/face/app.js') }}"></script>
<!-- <script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script> -->
<!-- <script type="text/javascript" src="{{ asset('js/map.js') }}"></script> -->

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KKD3L3T');</script>
