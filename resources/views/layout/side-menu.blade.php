@if(Auth()->user())

@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    @include('../layout/components/top-bar')
    <style>
/* Fullscreen overlay */
.image-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8); /* dark background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    visibility: hidden; /* hidden by default */
    opacity: 0;
    transition: opacity 0.3s;
}

/* Show overlay */
.image-overlay.active {
    visibility: visible;
    opacity: 1;
}

/* Image styling */
.image-overlay img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
}

/* Close button centered on image */
.closebtn {
    position: absolute;
    top: 10px;    /* distance from top of image */
    right: 10px;  /* distance from right of image */
    font-size: 28px;
    font-weight: bold;
    color: white;
    background: rgba(0,0,0,0.5);
    padding: 5px 10px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10000;
}
</style>
    <div class="flex overflow-hidden">
        <nav class="side-nav">
            <ul>
                @php
                  // Fetch app name for display
                  $appName = strtolower(getProfessionTitle() ?: 'partner');

                  // Use optimized menu generation
                  $side_menu = \App\Main\SideMenu::dynamicMenu();
                @endphp
                @foreach ($side_menu as $menuKey => $menu)
                    @if ($menu == 'devider')
                        <li class="side-nav__devider my-6"></li>
                    @else
                        <li>
                            <a href="{{ isset($menu->route) ? route($menu->route) : 'javascript:;' }}"
                                class="{{ $first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                <div class="side-menu__icon">
                                    <i data-lucide="{{ $menu->icon }}"></i>
                                </div>
                                <div class="side-menu__title">
                                    @if($menu->pageName=='Astrologers')
                                    {{ $appName }}
                                    @else
                                    {{ $menu->pageName }}
                                    @endif
                                    @if (isset($menu->sub_menu) && count($menu->sub_menu) > 0)
                                        <div
                                            class="side-menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                                            <i data-lucide="chevron-down"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            @if (isset($menu->sub_menu))
                                <ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                                    @foreach ($menu->sub_menu as $subMenuKey => $subMenu)
                                        <li>
                                            <a href="{{ isset($subMenu->route) ? route($subMenu->route) : 'javascript:;' }}"
                                                class="{{ $second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                <div class="side-menu__icon">
                                                    {{-- <i data-lucide="activity"></i> --}}
                                                    <i data-lucide="{{ $subMenu->icon }}"></i>
                                                </div>
                                                <div class="side-menu__title">
                                                    @if(preg_match('/Astrologer(s)?/i', $subMenu->pageName))
                                                    {{ preg_replace('/Astrologer(s)?/i',$appName, $subMenu->pageName) }}
                                                    @else
                                                        {{ $subMenu->pageName }}
                                                    @endif


                                                    @if (isset($subMenu->sub_menu))
                                                        <div
                                                            class="side-menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                                                            <i data-lucide="chevron-down"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                            @if (isset($subMenu->sub_menu))
                                                <ul
                                                    class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                                    @foreach ($subMenu->sub_menu as $lastSubMenuKey => $lastSubMenu)
                                                        <li>
                                                            <a href="{{ isset($lastSubMenu->route) ? route($lastSubMenu->route) : 'javascript:;' }}"
                                                                class="{{ $third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                                <div class="side-menu__icon">
                                                                    <i data-lucide="zap"></i>
                                                                </div>
                                                                <div class="side-menu__title">{{ $lastSubMenu->pageName }}
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection
@endif
