<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('cms.dashboard') }}">
            <span class="align-middle">{{ $settings->name }}</span>
        </a>

        <ul class="sidebar-nav">
            @foreach($menus as $menu)
                @php
                    $isActive = false;

                    // Check if menu is active
                    $isActive = request()->routeIs($menu->route);
                @endphp

                @if($menu->type != 'header')
                    @can('view.'.$menu->route)

                        @if(!auth()->user()->hasRole('admin'))
                            @if(auth()->user()->userHotel->hotel->type == 'hospital' && $menu->name == 'Hotel')
                                {{-- Dont show hotel if user is admin hospital --}}
                            @elseif(auth()->user()->userHotel->hotel->type == 'hotel' && in_array($menu->name, [
                                'Hospital',
                                'Doctor Category',
                                'Doctor',
                            ]))
                                {{-- Dont show hospital if user is admin hotel --}}
                            @else
                                <li class="sidebar-{{ $menu->type }} {{ $isActive ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{
                                        \Illuminate\Support\Facades\Route::has($menu->route)
                                        ? route($menu->route)
                                        : '#'
                                    }}">
                                        @if($menu->type != 'header')
                                            <i class="align-middle" data-feather="{{ $menu->icon }}"></i>
                                        @endif
                                        <span class="align-middle">{{ $menu->name }}</span>
                                    </a>
                                </li>
                            @endif

                        @else

                            <li class="sidebar-{{ $menu->type }} {{ $isActive ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{
                                    \Illuminate\Support\Facades\Route::has($menu->route)
                                    ? route($menu->route)
                                    : '#'
                                }}">
                                    @if($menu->type != 'header')
                                        <i class="align-middle" data-feather="{{ $menu->icon }}"></i>
                                    @endif
                                    <span class="align-middle">{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endif

                    @endcan

                {{-- if admin --}}
                @elseif(auth()->user()->hasRole('admin'))
                    @if(in_array($menu->name, [
                        'Settings',
                        'Master',
                    ]))
                        <li class="sidebar-header">{{ $menu->name }}</li>
                    @endif

                {{-- if admin hotel / hospital --}}
                @elseif(auth()->user()->hasRole('admin_hotel'))
                    @if(auth()->user()->userHotel->hotel->type == 'hospital' && $menu->name == 'Hotel')
                        {{-- Dont show hotel if user is admin hospital --}}
                    @elseif(auth()->user()->userHotel->hotel->type == 'hotel' && $menu->name == 'Hospital')
                        {{-- Dont show hospital if user is admin hotel --}}
                    @else
                        <li class="sidebar-header">{{ $menu->name }}</li>
                    @endif

                {{-- if Receptionist --}}
                @elseif(!auth()->user()->hasRole('receptionist'))
                    <li class="sidebar-header">{{ $menu->name }}</li>
                @endif

            @endforeach
        </ul>
    </div>
</nav>

