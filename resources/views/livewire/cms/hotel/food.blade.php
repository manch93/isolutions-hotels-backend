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
                                <td>{{ $d->hotel }}</td>
                                <td>{{ $d->name }}</td>
                                <td>{{ $d->price }}</td>
                                <td>{{ $d->description }}</td>
                                <td>{{ $d->image }}</td>
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

                <div class="float-end">
                    {{ $get->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Create / Update Modal --}}
    <x-acc-modal title="{{ $isUpdate ? 'Update' : 'Create' }} {{ $title }}">
        <x-acc-form submit="saveWithUpload">
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
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="form.name" class="form-control" placeholder="Name">
                    <x-acc-input-error for="form.name" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" wire:model="form.price" class="form-control" placeholder="Price">
                    <x-acc-input-error for="form.price" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea wire:model="form.description" class="form-control" placeholder="Description"></textarea>
                    <x-acc-input-error for="form.description" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <x-acc-image-preview :$image :form_image="$form->image"  />
                    <input type="file" wire:model="image" class="form-control">
                    <x-acc-input-error for="form.image" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</div>
