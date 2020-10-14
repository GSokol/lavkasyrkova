<!DOCTYPE html>
<html>
<head>
    @include('face.components.head')
</head>
<body>
    @if (!Auth::guest() && !Auth::user()->is_admin)
        @include('layouts._checkout_modal_block', ['usingAjax' => true])
    @endif

    @include('face.components.header')

    {{ csrf_field() }}

    @yield('content')

    @include('face.components.footer')

    @include('layouts._product_modal_block')
    @include('layouts._message_modal_block')
</body>
</html>
