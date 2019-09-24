<nav class="navbar navbar-default navbar-static-top">
    @include('layouts._basket_block', ['className' => 'visible-xs'])
    <div class="navbar-header">
        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <div class="container">
            <div class="logo hidden-xs"><a href="#home" data-scroll="home"><img src="{{ asset('images/logo_small.svg') }}" /></a></div>
        <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav dropdown">
                @foreach($mainMenu as $menu)
                    @if ($menu['name'])
                        <li class="main-menu">
                            @if ($menu['href'])
                                @if ($menu['href'] == 'login' || $menu['href'] == 'register' || $menu['href'] == 'admin' || $menu['href'] == 'profile')
                                    <a href="/{{ $menu['href'] }}">{{ $menu['name'] }}</a>
                                @else
                                    <a href="#{{ $menu['href'] }}" data-scroll="{{ $menu['href'] }}">{{ $menu['name'] }}</a>
                                @endif

                            @else
                                <a>{{ $menu['name'] }}</a>
                            @endif

                            @if (isset($menu['submenu']) && is_array($menu['submenu']))
                                <ul class="dropdown-menu hidden-xs">
                                    @foreach($menu['submenu'] as $menu)
                                        <li><a href="#{{ $menu['href'] }}" data-id="{{ $menu['id'] }}" data-type="{{ $menu['type'] }}" data-scroll="{{ $menu['href'] }}">{{ $menu['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
            @include('layouts._basket_block', ['className' => 'hidden-xs'])
        </div>
    </div>
</nav>