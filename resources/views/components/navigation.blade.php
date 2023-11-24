<div>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="{{ route('cms.dashboard') }}" wire:navigate>
                <span class="align-middle">{{ $settings->name }}</span>
            </a>

            <ul class="sidebar-nav">
                @foreach($menus as $menu)
                    <li class="sidebar-{{ $menu->type }}">
                        @if($menu->type != 'header')
                        <a class="sidebar-link" href="{{
                            \Illuminate\Support\Facades\Route::has($menu->route)
                            ? route($menu->route)
                            : '#'
                        }}" wire:navigate>
                        @endif
                            @if($menu->type != 'header')
                                <i class="align-middle" data-feather="{{ $menu->icon }}"></i>
                            @endif
                            <span class="align-middle">{{ $menu->name }}</span>
                        @if($menu->type != 'header')
                        </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</div>
