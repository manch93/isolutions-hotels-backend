<x-acc-with-alert>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <x-acc-header :$originRoute />
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
                                <td>{{ $d->url }}</td>
                                <td>{{ $d->type }}</td>
                                <td>{{ $d->headers ?? '-' }}</td>
                                <td>{{ $d->body ?? '-' }}</td>
                                <td>{{ $d->channels_count }}</td>
                                <td>{!! $d->active ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' !!}</td>
                                <x-acc-update-delete :id="$d->id" :$originRoute>
                                    <a
                                        href="{{ route('cms.management.m3u-channel.detail', ['source' => $d->id]) }}"
                                        class="btn btn-primary"
                                        wire:navigate
                                    >
                                        <i class="align-middle" data-feather="monitor"></i> Channels
                                    </a>
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
    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}" :$isModalOpen>
        <x-acc-form submit="save">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.name" class="form-control" placeholder="Name">
                    <x-acc-input-error for="form.name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" wire:model="form.url" class="form-control" placeholder="URL">
                    <x-acc-input-error for="form.url" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select wire:model="form.type" class="form-control">
                        <option value="">--Select Type--</option>
                        <option value="POST">POST</option>
                        <option value="GET">GET</option>
                    </select>
                    <x-acc-input-error for="form.type" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Header</label>
                    <textarea wire:model="form.headers" class="form-control" placeholder="Header"></textarea>
                    <x-acc-input-error for="form.headers" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Body</label>
                    <textarea wire:model="form.body" class="form-control" placeholder="Body"></textarea>
                    <x-acc-input-error for="form.body" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Active</label>
                    <select wire:model="form.active" class="form-control">
                        <option value="">--Select Status--</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <x-acc-input-error for="form.active" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</x-acc-with-alert>
