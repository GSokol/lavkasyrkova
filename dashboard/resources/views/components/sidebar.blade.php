<div class="sidebar-content">
    <div class="sidebar-user">
        <div class="category-content">
            <div class="media">
                <div class="media-body">
                    <div class="text-size-mini text-muted">
                        <i class="glyphicon glyphicon-user text-size-small"></i> Добро пожаловать<br>{{ auth()->guard('dashboard')->user()->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-category sidebar-category-visible">
        <div class="category-content no-padding">
            <ul class="navigation navigation-main navigation-accordion">
                @foreach ($menus as $menu)
                    @if ($menu['href'] == '/')
                        <li><a href="{{ url('/') }}"><i class="{{ $menu['icon'] }}"></i> <span>{{ Str::limit($menu['name'], 20) }}</span></a></li>
                    @else
                        <li {{ preg_match('/^('.str_replace('/', '\/', $menu['href']).')/', Request::path()) ? 'class="active"' : '' }}>
                            <a href="{{ $menu['href'] }}"><i class="{{ $menu['icon'] }}"></i> <span>{{ Str::limit($menu['name'], 20) }}</span></a>
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
                                        <li {{ (preg_match('/^('.str_replace('/','\/',$menu['href'].'/'.$submenu['href']).')/', Request::path())) || (Request::path() == $prefix.'/products' && Request::has('id') && Request::input('id') == (int)str_replace('?id=','',$submenu['href'])) ? 'class="active"' : '' }}>
                                            <a href="{{ $menu['href'].'/'.$submenu['href'] }}" {!! $addAttrStr !!}>{{ Str::limit($submenu['name'], 20) }}</a>
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
</div>
