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

            @if (isset($tastings) && !auth()->check() && Auth::user()->office->id != 1 && Auth::user()->office->id != 2)
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="icon-trophy2"></i>
                        <span class="position-right hidden-xs">Ближайшие дегустации</span>
                        @if (count($tastings))
                            <span class="badge bg-warning-400">{{ count($tastings) }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-content">
                        @if (count($tastings))
                            <div class="dropdown-content-heading">Дегустации</div>
                            <ul class="media-list dropdown-content-body width-350">
                                @foreach($tastings as $tasting)
                                    <li class="media">
                                        <div class="media-body">
                                            {{ date('d.m.Y', $tasting->time) }}
                                            <div class="media-annotation">{{ $tasting->office->address }}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="dropdown-content-heading">Нет открытых дегустаций</div>
                        @endif
                    </div>
                </li>
            @endif
        </ul>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <span>{{ auth('dashboard')->user()->email }}</span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="{{ route('dashboard.logout') }}"><i class="icon-switch2"></i> {{ trans('auth.logout') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
