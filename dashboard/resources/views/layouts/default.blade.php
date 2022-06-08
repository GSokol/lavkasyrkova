<!DOCTYPE html>
<html lang="ru">
<head>
    @include('dashboard::components.head')
</head>

<body>
@include('layouts._message_modal_block')

@if (!auth()->guard('dashboard')->check())
    @include('layouts._checkout_modal_block', ['usingAjax' => true])
@endif

@if (count($errors))
    @foreach ($errors as $error)
        {{ $error }}
    @endforeach
@endif

<div id="root">
    @include('dashboard::components.navbar')
    <div class="page-container">
        <div class="page-content">
            <div class="sidebar sidebar-main">
                @include('dashboard::components.sidebar')
            </div>
            <div class="content-wrapper">
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4>
                                <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Главная</span>
                                @if (isset($breadcrumbs))
                                    @foreach ($breadcrumbs as $href => $crumb)
                                        {{ '- '.strip_tags($crumb) }}
                                    @endforeach
                                @endif
                             </h4>
                        </div>
                    </div>

                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="{{ url('/') }}"><i class="icon-home2 position-left"></i>Главная</a></li>
                            @if (isset($breadcrumbs))
                                @foreach ($breadcrumbs as $href => $crumb)
                                    <li><a href="{{ url('/'.$href) }}">{{ strip_tags($crumb) }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="content">@yield('content')</div>
            </div>
        </div>
    </div>
</div>

@routes('dashboard')
@shared
@yield('js')
</body>
</html>
