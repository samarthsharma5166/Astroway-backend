<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar" style="background-color:#426f7f">
        <a href="" class="flex mr-auto">
            @php
                $logo = DB::table('systemflag')
                    ->where('name', 'AdminLogo')
                    ->select('value')
                    ->first();
            @endphp
            <img alt="Midone - HTML Admin Template" class="w-6" src="/{{ $logo->value }}">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler">
            <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler">
            <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
        <ul class="scrollable__content py-2">
            @php
                  $appName = strtolower(getProfessionTitle() ?: 'partner');

                  $side_menu = \App\Main\SideMenu::dynamicMenu();
            @endphp
            @foreach ($side_menu as $menuKey => $menu)
                @if ($menu == 'devider')
                    <li class="menu__devider my-6"></li>
                @else
                    <li>
                        <a href="{{ isset($menu->route) ? route($menu->route) : 'javascript:;' }}"
                            class="{{ $first_level_active_index == $menuKey ? 'menu menu--active' : 'menu' }}">
                            <div class="menu__icon">
                                <i data-lucide="{{ $menu->icon }}"></i>
                            </div>
                            <div class="menu__title">
                                @if($menu->pageName=='Astrologers')
                                {{ $appName }}
                                @else
                                {{ $menu->pageName }}
                                @endif
                                @if (isset($menu->sub_menu) && count($menu->sub_menu) > 0)
                                    <i data-lucide="chevron-down"
                                        class="menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}"></i>
                                @endif
                            </div>
                        </a>
                        @if (isset($menu->sub_menu))
                            <ul class="{{ $first_level_active_index == $menuKey ? 'menu__sub-open' : '' }}">
                                @foreach ($menu->sub_menu as $subMenuKey => $subMenu)
                                    <li>
                                        <a href="{{ isset($subMenu->route) ? route($subMenu->route) : 'javascript:;' }}"
                                            class="{{ $second_level_active_index == $subMenuKey ? 'menu menu--active' : 'menu' }}">
                                            <div class="menu__icon">
                                                <i data-lucide="{{ $subMenu->icon }}"></i>
                                            </div>
                                            <div class="menu__title">
                                                @if(preg_match('/Astrologer(s)?/i', $subMenu->pageName))
                                                {{ preg_replace('/Astrologer(s)?/i',$appName, $subMenu->pageName) }}
                                                @else
                                                    {{ $subMenu->pageName }}
                                                @endif
                                                @if (isset($subMenu->sub_menu))
                                                    <i data-lucide="chevron-down"
                                                        class="menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}"></i>
                                                @endif
                                            </div>
                                        </a>
                                        @if (isset($subMenu->sub_menu))
                                            <ul
                                                class="{{ $second_level_active_index == $subMenuKey ? 'menu__sub-open' : '' }}">
                                                @foreach ($subMenu->sub_menu as $lastSubMenuKey => $lastSubMenu)
                                                    <li>
                                                        <a href="{{ isset($lastSubMenu->route) ? route($lastSubMenu->route) : 'javascript:;' }}"
                                                            class="{{ $third_level_active_index == $lastSubMenuKey ? 'menu menu--active' : 'menu' }}">
                                                            <div class="menu__icon">
                                                                <i data-lucide="zap"></i>
                                                            </div>
                                                            <div class="menu__title">{{ $lastSubMenu->pageName }}</div>
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
    </div>
</div>
<!-- END: Mobile Menu -->
