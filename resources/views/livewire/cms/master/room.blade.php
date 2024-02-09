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
                                <td>{{ $d->hotel }}</td>
                                <td>{{ $d->room_type }}</td>
                                <td>{{ $d->no }}</td>
                                <td>{!! $d->guest_name ?? '<span class="text-danger">Empty</span>' !!}</td>
                                <td>{{ $d->greeting }}</td>
                                <td>{{ $d->device_name }}</td>
                                <x-acc-update-delete :id="$d->id" :$originRoute />
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
            @if(auth()->user()->hasRole('admin'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Hotel</label>
                        <select class="form-control" wire:model="form.hotel_id" wire:change="getRoomType">
                            <option value="">--Select Hotel--</option>
                            @foreach ($hotels as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        <x-acc-input-error for="form.hotel_id" />
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <select class="form-control" wire:model="form.room_type_id">
                        <option value="">--Select Room Type--</option>
                        @foreach ($roomTypes as $rt)
                            <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                        @endforeach
                    </select>
                    <x-acc-input-error for="form.room_type_id" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">No</label>
                    <input type="text" wire:model="form.no" class="form-control" placeholder="No">
                    <x-acc-input-error for="form.no" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Greeting</label>
                    <input type="text" wire:model="form.greeting" class="form-control" placeholder="Greeting">
                    <x-acc-input-error for="form.greeting" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Device Name</label>
                    <input type="text" wire:model="form.device_name" class="form-control" placeholder="Device Name">
                    <x-acc-input-error for="form.device_name" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</div>
