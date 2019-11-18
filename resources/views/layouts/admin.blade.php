<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Settings::getSeoTags()['title'] ? Settings::getSeoTags()['title'] : '' }}. Админка</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    {{--<link href="{{ asset('css/bootstrap-switch.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/products.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('js/plugins/loaders/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-switch.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/inputs/typeahead/handlebars.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/daterangepicker.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/pickers/anytime.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.time.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/legacy.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/picker_date.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/selects/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/media/fancybox.min.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('js/pages/components_thumbnails.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('js/pages/datatables_basic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/gallery.js') }}"></script>
{{--    <script type="text/javascript" src="{{ asset('js/plugins/pickers/color/spectrum.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('js/core/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/core/main.controls.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('js/pages/picker_color.js') }}"></script>--}}
    <!-- /theme JS files -->
    <script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/input-value.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/products.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>

    <script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
</head>

<body>
@include('layouts._message_modal_block')

@if (!Auth::user()->is_admin)
    @include('layouts._checkout_modal_block',['usingAjax' => true])
@endif

@if (count($errors))
    <script>
        showMessage('Не все поля заполнены верно! Ошибки валидации отмечены красным.');
    </script>
@endif

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <div class="navbar-right">
            <ul class="nav navbar-nav">

                @if (!Auth::user()->is_admin)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle total-cost-basket" data-toggle="dropdown" aria-expanded="false">
                            <i class="icon-cart5"></i>
                            <span class="badge bg-warning-400">{{ Session::has('basket') ? Session::get('basket')['total'] : '0' }}р.</span>
                        </a>

                        <div class="dropdown-menu dropdown-content width-200">
                            <ul class="media-list dropdown-content-body">
                                <li class="media"><a href="#checkout-modal" data-toggle="modal" class="media-heading">Оформить заказ</a></li>
                                <li class="media"><a href="#" id="empty-basket" class="media-heading">Очистить корзину</a></li>
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <span>{{ Auth::user()->email }}</span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="{{ url('/logout') }}"><i class="icon-switch2"></i> {{ trans('auth.logout') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<!-- Main sidebar -->
<div class="sidebar sidebar-main">
<div class="sidebar-content">

<!-- User menu -->
<div class="sidebar-user">
    <div class="category-content">
        <div class="media">
            <div class="media-body">
                <div class="text-size-mini text-muted">
                    <i class="glyphicon glyphicon-user text-size-small"></i> Добро пожаловать<br>{{ Auth::user()->email }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /user menu -->

<!-- Main navigation -->
<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
            <!-- Main -->
            @foreach ($menus as $menu)
                @if ($menu['href'] == '/')
                    <li><a href="{{ url('/') }}"><i class="{{ $menu['icon'] }}"></i> <span>{{ str_limit($menu['name'], 20) }}</span></a></li>
                @else
                    <li {{ preg_match('/^('.$prefix.'\/'.str_replace('/','\/',$menu['href']).')/', Request::path()) ? 'class=active' : '' }}>
                        <a href="{{ url('/'.$prefix.'/'.$menu['href']) }}"><i class="{{ $menu['icon'] }}"></i> <span>{{ str_limit($menu['name'], 20) }}</span></a>
                        @if (isset($menu['submenu']) && count($menu['submenu']))
                            <ul>
                                @foreach ($menu['submenu'] as $submenu)
                                    <?php
                                    $addAttrStr = '';
                                    if (isset($submenu['addAttr']) && count($submenu['addAttr']) ) {
                                        foreach ($submenu['addAttr'] as $attr => $val) {
                                            $addAttrStr .= $attr.'="'.$val.'"';
                                        }
                                    }
                                    ?>
                                    <li {{ (preg_match('/^('.$prefix.'\/'.str_replace('/','\/',$menu['href'].'/'.$submenu['href']).')/', Request::path())) || (Request::path() == $prefix.'/products' && Request::has('id') && Request::input('id') == (int)str_replace('?id=','',$submenu['href'])) ? 'class=active' : '' }}>
                                        <a href="{{ url('/'.$prefix.'/'.$menu['href'].'/'.$submenu['href']) }}" {!! $addAttrStr !!}>{{ str_limit($submenu['name'], 20) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<!-- /main navigation -->

</div>
</div>
<!-- /main sidebar -->


<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Главная</span>
                    @foreach ($breadcrumbs as $href => $crumb)
                        {{ '- '.strip_tags($crumb) }}
                    @endforeach
                 </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{ url('/'.$prefix) }}"><i class="icon-home2 position-left"></i>Главная</a></li>
                @foreach ($breadcrumbs as $href => $crumb)
                    <li><a href="{{ url('/'.$prefix.'/'.$href) }}">{{ strip_tags($crumb) }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">@yield('content')</div>
    <!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>