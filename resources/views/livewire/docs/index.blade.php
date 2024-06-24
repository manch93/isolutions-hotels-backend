<div>
    <style>
        img {
            max-width: 100%;
            max-height: 500px;
        }
    </style>
    <div id="content">
        @if(!$documentation)
            <div style="text-align: center">
                <h1>Documentation not found</h1>
            </div>
        @else
            {!! $documentation->description !!}
        @endif
    </div>
</div>
