<!DOCTYPE html>
<html>
<head>
    @include('components.head')
</head>
<body>
    @if (!Auth::guest() && !Auth::user()->is_admin)
        @include('layouts._checkout_modal_block', ['usingAjax' => true])
    @endif

    @include('components.header')

    {{ csrf_field() }}

    @yield('content')

    @include('components.footer')

    @include('layouts._product_modal_block')
    @include('layouts._message_modal_block')
</body>
</html>
