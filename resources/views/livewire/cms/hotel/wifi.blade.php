<x-acc-with-alert>
    <h1 class="h3 mb-3">
        {{ $title ?? '' }}
    </h1>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? '' }} Data</h5>
        </div>
        <div class="card-body">
            <x-acc-header :$originRoute />
            <div class="table-responsive">
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
                                <td>{{ $d->security_type }}</td>
                                <td>{{ $d->ssid_name }}</td>
                                <td>{{ $d->ssid_password }}</td>
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
            </div>
            <div class="float-end">
                {{ $get->links() }}
            </div>
        </div>
    </div>

    {{-- Create / Update Modal --}}
    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}" :isModaOpen="$modals['defaultModal']">
        <x-acc-form submit="customSave">
            @if(auth()->user()->hasRole('admin'))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Hotel</label>
                        <select class="form-control" wire:model="form.hotel_id">
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
                    <label class="form-label">Security Type</label>
                    <select wire:model="form.security_type" class="form-control">
                        <option value="">--Select Type--</option>
                        <option value="WPA">WPA</option>
                        <option value="WPA2">WPA2</option>
                        <option value="WPA/WPA2">WPA/WPA2</option>
                        <option value="WPA3">WPA3</option>
                    </select>
                    <x-acc-input-error for="form.security_type" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">SSID Name</label>
                    <input type="text" wire:model="form.ssid_name" class="form-control" placeholder="SSID Name">
                    <x-acc-input-error for="form.ssid_name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">SSID Password</label>
                    <input type="text" wire:model="form.ssid_password" class="form-control" placeholder="SSID Password">
                    <x-acc-input-error for="form.ssid_password" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</x-acc-with-alert>
