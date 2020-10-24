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

<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<link href="{{ mix('style/auth.css') }}" rel="stylesheet" type="text/css">

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/loaders/blockui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/core/app.js') }}"></script>
