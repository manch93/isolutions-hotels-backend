@props([
    'id' => 0,
    'modal' => 'acc-modal',
    'edit' => true,
    'delete' => true,
])

<td>
    {{ $slot ?? '' }}
    @if($edit)
        <button
            class="btn btn-warning"
            wire:click="edit({{ $id }})"
            @click="new bootstrap.Modal(document.getElementById('{{ $modal }}')).show()"
        >
            <i class="align-middle" data-feather="edit"></i>
        </button>
    @endif
    @if($delete)
        <button
            class="btn btn-danger"
            wire:click="confirmDelete({{ $id }})"
        >
            <i class="align-middle" data-feather="trash"></i>
        </button>
    @endif
</td>
