<x-acc-with-alert>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <div class="card-body">
            <x-acc-header :$originRoute>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Filter by Content</label>
                        <div class="input-group">
                            <select class="form-control" wire:model.live="filterByContent">
                                <option value="">--All Contents--</option>
                                @foreach ($contents as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                            @if($filterByContent)
                                <button type="button" class="btn btn-outline-secondary" wire:click="resetContentFilter" title="Clear Filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                                        <path d="m18 6l-12 12"/>
                                        <path d="m6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </x-acc-header>
            
            @if($filterByContent)
                <div class="alert alert-info d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                        <path d="M5.5 8.5l9 9"/>
                        <path d="M14 5l5 5"/>
                        <path d="M6 18h8"/>
                        <path d="M3 12l18 0"/>
                    </svg>
                    <div>
                        Filtered by Content: <strong>{{ $contents->firstWhere('id', $filterByContent)?->name ?? 'Unknown Content' }}</strong>
                        <span class="badge bg-primary ms-2">{{ $get->total() }} items</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" wire:click="resetContentFilter">
                            Clear Filter
                        </button>
                    </div>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <x-acc-loop-th :$searchBy :$orderBy :$order />
                            <th class="w-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($get as $d)
                            <tr>
                                <td>{{ $d->content }}</td>
                                <td>{{ $d->name }}</td>
                                <td>{{ Str::limit($d->description, 50) }}</td>
                                <td>
                                    @if($d->image)
                                        <img src="{{ $d->image }}" alt="{{ $d->name }}" class="img-thumbnail" style="max-width: 100px; max-height: 60px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($d->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <x-acc-update-delete editFunction="customEdit" :id="$d->id" :$originRoute />
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
        <x-acc-form submit="saveWithUpload">
            @if(auth()->user()->hasRole(['admin', 'admin_reseller']))
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Hotel (Filter Contents)</label>
                        <select class="form-control" wire:model.live="form.hotel_id" wire:change="getContentsByHotel($event.target.value)">
                            <option value="">--Select Hotel--</option>
                            @foreach ($hotels as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select hotel to filter available contents</small>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <select class="form-control" wire:model="form.content_id">
                        <option value="">--Select Content--</option>
                        @foreach ($contents as $content)
                            <option value="{{ $content->id }}">{{ $content->name }}</option>
                        @endforeach
                    </select>
                    <x-acc-input-error for="form.content_id" />
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
                    <label class="form-label">Description</label>
                    <textarea wire:model="form.description" class="form-control" rows="3" placeholder="Description"></textarea>
                    <x-acc-input-error for="form.description" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <x-acc-image-preview :$image :form_image="$form->image" />
                    <x-acc-input-file model="image" :$imageIttr />
                    <x-acc-input-error for="form.image" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Is Active</label>
                    <select wire:model="form.is_active" class="form-control">
                        <option value="">--Select Status--</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <x-acc-input-error for="form.is_active" />
                </div>
            </div>
        </x-acc-form>
    </x-acc-modal>
</x-acc-with-alert>
