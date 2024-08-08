<x-acc-with-alert>
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
                <x-acc-header :$originRoute createFunction="customCreate" />
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
                                <td>{{ $d->hotel }}</td>
                                <td>{{ $d->source }}</td>
                                <td>
                                    @if($d->alternative_name)
                                        {{ $d->alternative_name }}
                                    @elseif($d->secondary_name)
                                        {{ $d->secondary_name }}
                                    @else
                                        {{ $d->name }}
                                    @endif
                                </td>
                                <td>{!! $d->active ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' !!}</td>
                                <x-acc-update-delete :id="$d->id" :$originRoute editFunction="customEdit">
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
    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}" :$isModalOpen>
        <x-acc-form submit="customSave">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Source</label>
                    <select class="form-control" wire:change="getChannelFromSource" wire:model.live="source_id">
                        <option value="">--Select Source--</option>
                        @foreach($source as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Channel</label>
                    <select class="form-control" wire:model="form.m3u_channel_id" id="channel">
                        <option value="">--Select Channel--</option>
                        @foreach($channel as $c)
                            <option value="{{ $c->id }}">{{ $c->secondary_name ? $c->secondary_name : $c->name }}</option>
                        @endforeach
                    </select>
                    <x-acc-input-error for="form.m3u_channel_id" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Alternative name</label>
                    <input type="text" wire:model="form.alternative_name" class="form-control" placeholder="Alternative name">
                    <x-acc-input-error for="form.alternative_name" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Active</label>
                    <select class="form-control" wire:model="form.active">
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
