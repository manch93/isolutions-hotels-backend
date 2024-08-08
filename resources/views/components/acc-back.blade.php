@props([
    'route' => '',
    'class' => 'btn btn-secondary',
    'routeParams' => [],
])
<a href="{{ route($route, $routeParams) }}" {!! $attributes !!} class="{{ $class }}">
    <i class="fa fa-arrow-left"></i>
    Back
</a>
