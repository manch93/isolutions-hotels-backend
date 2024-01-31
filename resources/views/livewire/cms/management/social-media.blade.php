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
                <x-acc-header :isSearch="false" />
                <table class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Icon
                            </th>
                            <th>
                                Link
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($form->social_media as $key => $d)
                            <tr>
                                <td>{{ $d['name'] }}</td>
                                <td>{{ $d['icon'] }}</td>
                                <td>{{ $d['url'] }}</td>
                                <x-acc-update-delete :id="$d->id" />
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
        </div>
    </div>

    {{-- Create / Update Modal --}}
    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}">
        <x-acc-form submit="saveSocialMedia">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.name" class="form-control" placeholder="Name">
                    <x-acc-input-error for="form.name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="text" wire:model="form.icon" class="form-control" placeholder="Icon">
                    <x-acc-input-error for="form.icon" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.url" class="form-control" placeholder="Url">
                    <x-acc-input-error for="form.url" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</div>
