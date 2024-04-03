@props(['isCreate' => true, 'isSearch' => true, 'originRoute' => '', 'createFunction' => 'create'])

<div>
    <div class="row mb-3">
        @if($isSearch)
            <div class="col-md-{{ $isCreate ? '6' : '12' }}">
                <x-acc-search />
            </div>
        @endif
        @if($isCreate)
            <div class="col-md-{{ $isSearch ? '6' : '12' }}">
                <x-acc-create-btn :route="$originRoute ?? ''" :$createFunction />
            </div>
        @endif
        {{ $slot->isEmpty() ? '' : $slot }}
    </div>
</div>
