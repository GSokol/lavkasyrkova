<nav class="navbar navbar-default navbar-static-top" data-scroll-destination="menu">
    @include('components._basket_block', ['className' => 'visible-xs'])

    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <div class="container">
            <div class="logo hidden-xs">
                <a href="/"><img src="{{ asset('images/logo_small.svg') }}" /></a>
            </div>
            <ul class="nav navbar-nav">
                @if ($actions && count($actions))
                    <li class="main-menu">
                        <a href="/#actions" data-scroll="actions">Предложения недели</a>
                    </li>
                @endif

                @foreach($mainMenu as $menu)
                    @if ($menu['name'])
                        <li class="main-menu @if (isset($menu['submenu']) && is_array($menu['submenu'])) {{'dropdown'}} @endif">
                            <a href="{{ $menu['href'] }}" @if (strpos($menu['href'], '#') !== false) data-scroll="{{ substr($menu['href'], 2) }}" @endif>{{ $menu['name'] }}</a>

                            @if (isset($menu['submenu']) && is_array($menu['submenu']))
                                <ul class="dropdown-menu hidden-xs">
                                    @foreach ($menu['submenu'] as $menu)
                                        <li><a href="{{ $menu['href'] }}">{{ $menu['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach

                @if (Auth::guest())
                    <li class="main-menu"><a href="/login">Войти</a></li>
                    <li class="main-menu"><a href="/register">Регистрация</a></li>
                @else
                    <li class="main-menu"><a href="/profile">Профиль</a></li>
                @endif
                @if (Auth::user()->is_admin)
                    <li class="main-menu"><a href="{{ route('dashboard.home') }}">Админка</a></li>
                @endif
            </ul>

            @include('components._basket_block', ['className' => 'hidden-xs'])
        </div>
    </div>
</nav>
