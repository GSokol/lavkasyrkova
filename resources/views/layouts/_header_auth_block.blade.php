<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
    {{ Settings::getSeoTags()['title'].'.' }}

    <?php
    switch (Request::path()) {
        case 'login':
            echo trans('auth.login');
            break;

        case 'register':
            echo trans('auth.register');
            break;

        default:
            echo trans('auth.reset_password');
            break;
    }
    ?>
</title>

<!-- Global stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/components.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/colors.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/auth.css') }}" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Core JS files -->
{{--<script type="text/javascript" src="/js/auth/plugins/loaders/pace.min.js"></script>--}}
<script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/loaders/blockui.min.js') }}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/core/app.js') }}"></script>