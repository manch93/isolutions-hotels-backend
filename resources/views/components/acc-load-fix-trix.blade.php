@props([
    'actionCallback' => 'closeModal',
])
<div x-data="{}" x-init="
    window.addEventListener('load', function () {
        setTimeout(() => {
            $wire.{{ $actionCallback }}();
            setTimeout(() => {
                document.querySelector('.spinner-wrapper').style.opacity = '0';
            }, 200)
            setTimeout(() => {
                document.querySelector('.spinner-wrapper').style.display = 'none';
            }, 500)
        }, 700)
    })
" wire:ignore>
    <style>
        .spinner-wrapper {
            background-color: #222e3c;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner-border {
            height: 60px;
            width: 60px;
            color: #fff;
        }
    </style>
    <div class="spinner-wrapper">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
