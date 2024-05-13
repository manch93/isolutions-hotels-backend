<div>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="float-start">
                        <button
                            class="btn btn-success"
                            wire:loading.attr="disabled"
                            wire:click="callApi"
                        >
                            <i class="align-middle" data-feather="plus-circle"></i>
                            Call Api
                        </button>
                        <button class="btn btn-primary" wire:click="activateAll" wire:loading.attr="disabled">
                            <i class="align-middle" data-feather="check"></i>
                            Activate All
                        </button>
                        <button class="btn btn-danger" wire:click="deactivateAll" wire:loading.attr="disabled">
                            <i class="align-middle" data-feather="x"></i>
                            Deactivate All
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <x-acc-header :$originRoute :isCreate="false" />
                <table class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <x-acc-loop-th :$searchBy :$orderBy :$order />
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($get as $d)
                            <tr>
                                <td>{{ $d->secondary_name ? $d->secondary_name : $d->name }}</td>
                                <td>{{ $d->url }}</td>
                                <td>{{ $d->icon ?? '-' }}</td>
                                <td>{!! $d->active ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' !!}</td>
                                <x-acc-update-delete :id="$d->id" :$originRoute :delete="false">
                                    @if($d->active)
                                        <button
                                            class="btn btn-danger"
                                            wire:click="deactivateChannel({{ $d->id }})"
                                            wire:loading.attr="disabled"
                                        >
                                            <i class="align-middle" data-feather="x"></i>
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-success"
                                            wire:click="activateChannel({{ $d->id }})"
                                            wire:loading.attr="disabled"
                                        >
                                            <i class="align-middle" data-feather="check"></i>
                                        </button>
                                    @endif
                                </x-acc-update-delete>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100" class="text-center">
                                    No Data Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="float-end">
                    {{ $get->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Create / Update Modal --}}
    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}">
        <x-acc-form submit="customSave">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.secondary_name" class="form-control">
                    <x-acc-input-error for="form.secondary_name" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <x-acc-image-preview :$image :form_image="$form->icon"  />
                    <x-acc-input-file model="image" :$imageIttr />
                    <x-acc-input-error for="image" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</div>
