<div>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-acc-header />
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
                                <td>{{ $d->name }}</td>
                                <td>{{ $d->branch }}</td>
                                <td>{{ $d->address }}</td>
                                <td>{{ $d->phone }}</td>
                                <td>{{ $d->email }}</td>
                                <td>{{ $d->website }}</td>
                                <td>{{ $d->default_greeting }}</td>
                                <td>
                                    <a href="{{ route('cms.master.hotel') }}" class="btn btn-primary" wire:navigate>
                                        <i class="align-middle" data-feather="edit"></i> Profile
                                    </a>
                                    <button
                                        class="btn btn-warning"
                                        wire:click="edit({{ $d->id }})"
                                        @click="new bootstrap.Modal(document.getElementById('acc-modal')).show()"
                                    >
                                        <i class="align-middle" data-feather="edit"></i>
                                    </button>
                                    <button
                                        class="btn btn-danger"
                                        wire:click="confirmDelete({{ $d->id }})"
                                    >
                                        <i class="align-middle" data-feather="trash"></i>
                                    </button>
                                </td>
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
        <x-acc-form submit="save">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.name" class="form-control" placeholder="Name">
                    <x-acc-input-error for="form.name" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Branch</label>
                    <input type="text" wire:model="form.branch" class="form-control" placeholder="Branch">
                    <x-acc-input-error for="form.branch" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" wire:model="form.address" class="form-control" placeholder="Address">
                    <x-acc-input-error for="form.address" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="number" wire:model="form.phone" class="form-control" placeholder="Phone">
                    <x-acc-input-error for="form.phone" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" wire:model="form.email" class="form-control" placeholder="Email">
                    <x-acc-input-error for="form.email" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="text" wire:model="form.website" class="form-control" placeholder="Website">
                    <x-acc-input-error for="form.website" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Default Greeting</label>
                    <input type="text" wire:model="form.default_greeting" class="form-control" placeholder="Default Greeting">
                    <x-acc-input-error for="form.default_greeting" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</div>
