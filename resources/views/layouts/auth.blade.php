<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.head_auth')
</head>

<body class="login-container">
@include('layouts._message_modal_block')

<div class="page-container">
    <div class="page-content">
        <div class="content-wrapper">
            <div class="content">
                <img id="logo" src="{{ asset('/images/logo.svg') }}" />
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script>
    $('.styled').uniform();
    $('input[name=phone]').mask("+7(9nn)nnn-nn-nn");
</script>

</body>
</html>
