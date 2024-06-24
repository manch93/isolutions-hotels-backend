<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->name }} Documentation</title>
    <meta name="description" content="{{ $settings->name }} Documentation">
    <meta name="author" content="{{ $settings->name }}">
    <link rel="stylesheet" href="{{ asset('pdocs/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,600&display=swap" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>
</head>
<body>

    <div class="navbar clear nav-top">
        <div class="row content">
            <a href="{{ route('docs.index') }}"  wire:navigate>
                <img src="{{ asset('storage/settings/' . $settings->logo) }}" class="logo">
            </a>
            <a class="right" href="{{ route('docs.index') }}" wire:navigate>
                <i class="fas fa-book"></i>
                &nbsp; Documentation
            </a>
            <a class="right" href="mailto:{{ $settings->email }}" target="_blank">
                <i class="fas fa-paper-plane"></i>
                &nbsp; {{ $settings->email }}
            </a>
        </div>
    </div>

    <div class="container clear">
        <div class="row wrapper">

            <div class="sidepanel">
                @persist('nav')
                    @foreach($menus as $nav)
                        <a class="{{ $nav->type == 'header' ? 'title' : 'section' }}" href="{{ url()->to('docs' . $nav->route) }}" wire:navigate>
                            @if($nav->icon != '-')
                                <i class="{{ $nav->icon }}"></i>
                            @endif
                            {{ $nav->name }}
                        </a>
                        @if($nav->type == 'header')
                            <div class="divider left"></div>
                        @endif
                    @endforeach
                @endpersist
                {{-- <div class="divider left"></div> --}}
                {{-- <div class="space double"></div> --}}
            </div>
            <div class="right-col">
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
</body>
</html>
