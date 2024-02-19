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
                <x-acc-header :$originRoute>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select class="form-control" wire:model.live="whereRoomType">
                                    <option value="">--Select Room Type--</option>
                                    @foreach ($roomTypes as $rt)
                                        <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </x-acc-header>
                <table class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <x-acc-loop-th :$searchBy :$orderBy :$order />
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($get as $d)
                            <tr>
                                <td>
                                    <button
                                        class="btn btn-primary btn-sm"
                                        @if(!empty($d->guest_name))
                                            disabled
                                        @endif
                                        wire:click="edit({{ $d->id }})"
                                        @click="new bootstrap.Modal(document.getElementById('acc-modal')).show()"
                                    >
                                        <i class="align-middle" data-feather="log-in"></i> Check In
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm"
                                        @if(empty($d->guest_name))
                                            disabled
                                        @endif
                                        wire:click="confirmCheckOut({{ $d->id }})"
                                    >
                                        <i class="align-middle" data-feather="log-out"></i> Check Out
                                    </button>
                                </td>
                                <td>{{ $d->room_type }}</td>
                                <td>{{ $d->no }}</td>
                                <td>{!! $d->guest_name ?? '<span class="text-danger">Empty</span>' !!}</td>
                                <td>{!! $d->is_birthday == 1 ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>' !!}</td>
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

    {{-- Check In --}}
    <x-acc-modal title="Check In">
        <x-acc-form submit="checkIn">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <input type="text" wire:model="form.room_type" class="form-control" placeholder="Room Type" readonly>
                    <x-acc-input-error for="form.room_type" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">No</label>
                    <input type="text" wire:model="form.no" class="form-control" placeholder="No" readonly>
                    <x-acc-input-error for="form.no" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Guest Name</label>
                    <input type="text" wire:model="form.guest_name" class="form-control" placeholder="Guest Name">
                    <x-acc-input-error for="form.guest_name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Is Birthday</label>
                    <select class="form-control" wire:model="form.is_birthday">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</div>
