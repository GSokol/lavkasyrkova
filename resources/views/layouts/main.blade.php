<!DOCTYPE html>
<html>
<head>
    @include('components.head')
</head>
<body>
    <div id="root">
    @if (!Auth::guest() && !Auth::user()->is_admin)
        @include('layouts._checkout_modal_block', ['usingAjax' => true])
    @endif

    @include('components.header')

    @yield('content')

    @include('components.footer')

    @include('layouts._product_modal_block')
    @include('layouts._message_modal_block')

    {{ csrf_field() }}
    </div>

    @shared
    <script src="{{ mix('js/face/store.js') }}"></script>
    @yield('js')
</body>
</html>
